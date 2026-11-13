<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * Create an order atomically from the user's cart items.
     *
     * @param  array{shipping_name: string, shipping_phone: string, shipping_address: string, payment_method: string, notes?: ?string}  $data
     *
     * @throws DomainException
     */
    public function placeOrder(User $user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data): Order {
            $cartItems = CartItem::query()
                ->where('user_id', $user->id)
                ->orderBy('id')
                ->get();

            if ($cartItems->isEmpty()) {
                throw new DomainException('Keranjang belanja masih kosong.');
            }

            // Lock products in deterministic ID order to avoid deadlocks under concurrency.
            $productIds = $cartItems->pluck('product_id')->sort()->values()->all();
            $products = Product::query()
                ->whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $totalAmount = 0;
            $preparedItems = [];

            foreach ($cartItems as $item) {
                $product = $products->get($item->product_id);

                if (! $product || ! $product->is_active) {
                    throw new DomainException('Salah satu produk di keranjang tidak lagi tersedia.');
                }

                if ($product->stock < $item->quantity) {
                    throw new DomainException("Stok untuk \"{$product->name}\" tidak mencukupi (tersisa {$product->stock}).");
                }

                $subtotal = $product->price * $item->quantity;
                $totalAmount += $subtotal;

                $preparedItems[] = [
                    'product' => $product,
                    'quantity' => $item->quantity,
                    'subtotal' => $subtotal,
                ];
            }

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $this->generateOrderNumber(),
                'total_amount' => $totalAmount,
                'status' => Order::STATUS_PENDING,
                'payment_method' => $data['payment_method'],
                'payment_status' => Order::PAYMENT_UNPAID,
                'shipping_name' => $data['shipping_name'],
                'shipping_phone' => $data['shipping_phone'],
                'shipping_address' => $data['shipping_address'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($preparedItems as $entry) {
                /** @var Product $product */
                $product = $entry['product'];
                $product->decrement('stock', $entry['quantity']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $entry['quantity'],
                    'subtotal' => $entry['subtotal'],
                ]);
            }

            CartItem::query()->where('user_id', $user->id)->delete();

            return $order->load('items');
        });
    }

    /**
     * Simulate/confirm payment for a pending order.
     *
     * @throws DomainException
     */
    public function markPaid(Order $order): Order
    {
        return DB::transaction(function () use ($order): Order {
            $lockedOrder = Order::query()->whereKey($order->id)->lockForUpdate()->firstOrFail();

            if (! $lockedOrder->canBePaid()) {
                throw new DomainException('Pesanan ini tidak dapat dibayar.');
            }

            $lockedOrder->update([
                'status' => Order::STATUS_PAID,
                'payment_status' => Order::PAYMENT_PAID,
                'paid_at' => now(),
            ]);

            return $lockedOrder->fresh('items');
        });
    }

    /**
     * Cancel an order and restore stock atomically.
     *
     * @throws DomainException
     */
    public function cancelOrder(Order $order, bool $forceAdmin = false): Order
    {
        return DB::transaction(function () use ($order, $forceAdmin): Order {
            $lockedOrder = Order::query()
                ->with('items')
                ->whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedOrder->status === Order::STATUS_CANCELLED) {
                throw new DomainException('Pesanan ini sudah dibatalkan.');
            }

            if (! $forceAdmin && ! $lockedOrder->canBeCancelled()) {
                throw new DomainException('Pesanan yang sudah diproses atau dikirim tidak dapat dibatalkan.');
            }

            $productIds = $lockedOrder->items
                ->pluck('product_id')
                ->filter()
                ->sort()
                ->values()
                ->all();

            $products = Product::query()
                ->whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($lockedOrder->items as $item) {
                if ($item->product_id && $products->has($item->product_id)) {
                    $products->get($item->product_id)->increment('stock', $item->quantity);
                }
            }

            $lockedOrder->update([
                'status' => Order::STATUS_CANCELLED,
                'payment_status' => $lockedOrder->payment_status === Order::PAYMENT_PAID
                    ? Order::PAYMENT_REFUNDED
                    : $lockedOrder->payment_status,
            ]);

            return $lockedOrder->fresh('items');
        });
    }

    /**
     * Update order status from the admin panel.
     */
    public function updateStatus(Order $order, string $newStatus, ?string $paymentStatus = null): Order
    {
        if ($newStatus === Order::STATUS_CANCELLED && $order->status !== Order::STATUS_CANCELLED) {
            return $this->cancelOrder($order, forceAdmin: true);
        }

        return DB::transaction(function () use ($order, $newStatus, $paymentStatus): Order {
            $lockedOrder = Order::query()->whereKey($order->id)->lockForUpdate()->firstOrFail();

            $attributes = ['status' => $newStatus];

            if ($paymentStatus !== null) {
                $attributes['payment_status'] = $paymentStatus;
                if ($paymentStatus === Order::PAYMENT_PAID && $lockedOrder->paid_at === null) {
                    $attributes['paid_at'] = now();
                }
            } elseif (
                in_array($newStatus, [Order::STATUS_PAID, Order::STATUS_COMPLETED], true)
                && $lockedOrder->payment_status === Order::PAYMENT_UNPAID
            ) {
                $attributes['payment_status'] = Order::PAYMENT_PAID;
                $attributes['paid_at'] = now();
            }

            $lockedOrder->update($attributes);

            return $lockedOrder->fresh('items');
        });
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
    }
}
