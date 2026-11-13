<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'revenue' => (int) Order::query()
                ->where('payment_status', Order::PAYMENT_PAID)
                ->where('status', '!=', Order::STATUS_CANCELLED)
                ->sum('total_amount'),
            'orders_total' => Order::count(),
            'orders_pending' => Order::where('status', Order::STATUS_PENDING)->count(),
            'products_total' => Product::count(),
            'categories_total' => Category::count(),
            'customers_total' => User::where('role', User::ROLE_CUSTOMER)->count(),
        ];

        $recentOrders = Order::query()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::query()
            ->with('category')
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}
