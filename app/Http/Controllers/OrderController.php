<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->withCount('items')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Request $request, Order $order): View
    {
        $this->authorizeView($request, $order);
        $order->load('items.product');

        return view('orders.show', [
            'order' => $order,
        ]);
    }

    public function payment(Request $request, Order $order): View|RedirectResponse
    {
        $this->authorizeOwner($request, $order);

        if ($order->payment_status === Order::PAYMENT_PAID) {
            return redirect()
                ->route('orders.show', $order)
                ->with('success', 'Pesanan ini sudah lunas.');
        }

        if ($order->status === Order::STATUS_CANCELLED) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Pesanan ini telah dibatalkan.');
        }

        $order->load('items.product');

        return view('orders.payment', [
            'order' => $order,
        ]);
    }

    public function pay(Request $request, Order $order, OrderService $orderService): RedirectResponse
    {
        $this->authorizeOwner($request, $order);

        try {
            $orderService->markPaid($order);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('orders.show', $order)
            ->with('success', '🎉 Simulasi pembayaran berhasil! Pesanan Anda telah lunas dan segera diproses.');
    }

    public function mockFail(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeOwner($request, $order);

        return back()->with('error', '⚠️ Simulasi Transaksi Gagal: Saldo tidak mencukupi atau koneksi pembayaran ditolak bank.');
    }

    public function cancel(Request $request, Order $order, OrderService $orderService): RedirectResponse
    {
        $this->authorizeOwner($request, $order);

        try {
            $orderService->cancelOrder($order);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
    }

    private function authorizeOwner(Request $request, Order $order): void
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }
    }

    private function authorizeView(Request $request, Order $order): void
    {
        $user = $request->user();
        if ($order->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403);
        }
    }
}
