<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = trim((string) $request->query('status', ''));
        $search = trim((string) $request->query('q', ''));

        $orders = Order::query()
            ->with('user')
            ->withCount('items')
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('order_number', 'like', "%{$search}%")
                        ->orWhere('shipping_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'status' => $status,
            'search' => $search,
            'statuses' => Order::STATUS_META,
        ]);
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => Order::STATUS_META,
            'paymentStatuses' => Order::PAYMENT_STATUS_META,
        ]);
    }

    public function update(Request $request, Order $order, OrderService $orderService): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUS_META))],
            'payment_status' => ['nullable', Rule::in(array_keys(Order::PAYMENT_STATUS_META))],
        ]);

        try {
            $orderService->updateStatus(
                $order,
                $validated['status'],
                $validated['payment_status'] ?? null
            );
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', "Status pesanan {$order->order_number} diperbarui.");
    }
}
