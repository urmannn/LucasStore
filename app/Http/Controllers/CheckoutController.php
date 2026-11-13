<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Services\OrderService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        $cartItems = CartItem::query()
            ->with('product')
            ->where('user_id', $user->id)
            ->orderBy('id')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja masih kosong.');
        }

        $total = $cartItems->sum(fn (CartItem $item) => $item->subtotal);

        return view('checkout.index', [
            'user' => $user,
            'cartItems' => $cartItems,
            'total' => $total,
            'paymentMethods' => Order::PAYMENT_METHODS,
        ]);
    }

    public function store(Request $request, OrderService $orderService): RedirectResponse
    {
        $validated = $request->validate([
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'payment_method' => ['required', Rule::in(array_keys(Order::PAYMENT_METHODS))],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $order = $orderService->placeOrder($request->user(), $validated);
        } catch (DomainException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        $targetRoute = $order->payment_method === 'cod'
            ? route('orders.show', $order)
            : route('orders.payment', $order);

        return redirect($targetRoute)
            ->with('success', "Pesanan {$order->order_number} berhasil dibuat! Silakan selesaikan pembayaran.");
    }
}
