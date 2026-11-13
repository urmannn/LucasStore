@extends('layouts.admin')

@section('title', 'Dashboard Admin — NusaStore')
@section('header', 'Ringkasan Toko')

@section('content')
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-3xl border border-emerald-200 bg-white p-5 shadow-xs">
        <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Total Pendapatan (Lunas)</p>
        <p class="mt-2 text-2xl font-black text-slate-900">{{ \App\Support\Money::rupiah($stats['revenue']) }}</p>
        <span class="mt-1 inline-block text-[11px] font-semibold text-emerald-600">✓ Transaksi Terverifikasi</span>
    </div>

    <div class="rounded-3xl border border-orange-200 bg-white p-5 shadow-xs">
        <p class="text-xs font-bold uppercase tracking-wider text-orange-700">Total Pesanan</p>
        <p class="mt-2 text-2xl font-black text-slate-900">{{ $stats['orders_total'] }}</p>
        <p class="mt-1 text-xs font-bold text-orange-600">{{ $stats['orders_pending'] }} menunggu pembayaran</p>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-xs">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Produk</p>
        <p class="mt-2 text-2xl font-black text-slate-900">{{ $stats['products_total'] }}</p>
        <p class="mt-1 text-xs text-slate-500">{{ $stats['categories_total'] }} kategori aktif</p>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-xs">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Pelanggan Terdaftar</p>
        <p class="mt-2 text-2xl font-black text-slate-900">{{ $stats['customers_total'] }}</p>
        <span class="mt-1 inline-block text-[11px] text-slate-400">Akun pembeli aktif</span>
    </div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-2">
    <!-- Recent Orders -->
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <span class="text-xs font-bold uppercase text-emerald-700">Pesanan Masuk</span>
                <h2 class="text-base font-black text-slate-900">Pesanan Terbaru</h2>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-700 hover:text-orange-500 transition">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="mt-4 divide-y divide-slate-100 text-sm">
            @forelse($recentOrders as $order)
                <div class="flex items-center justify-between py-3">
                    <div>
                        <a href="{{ route('admin.orders.show', $order) }}" class="font-mono font-bold text-slate-900 hover:text-emerald-700 transition">
                            {{ $order->order_number }}
                        </a>
                        <p class="text-xs text-slate-500">{{ $order->shipping_name }} &bull; {{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-slate-900">{{ $order->formatted_total }}</p>
                        <span class="inline-block rounded-full border px-2.5 py-0.5 text-[11px] font-bold {{ $order->status_badge }}">
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="py-6 text-center text-slate-400 text-xs">Belum ada pesanan.</p>
            @endforelse
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <span class="text-xs font-bold uppercase text-orange-700">Inventaris</span>
                <h2 class="text-base font-black text-slate-900">Stok Menipis (&le; 5 unit)</h2>
            </div>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-emerald-700 hover:text-orange-500 transition">
                Kelola Produk &rarr;
            </a>
        </div>

        <div class="mt-4 divide-y divide-slate-100 text-sm">
            @forelse($lowStockProducts as $product)
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-lg object-cover bg-slate-100 border border-slate-200">
                        <div>
                            <a href="{{ route('admin.products.edit', $product) }}" class="font-bold text-slate-900 hover:text-emerald-700">
                                {{ $product->name }}
                            </a>
                            <p class="text-xs text-slate-500">{{ $product->category?->name }}</p>
                        </div>
                    </div>
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ $product->stock === 0 ? 'bg-rose-100 text-rose-800' : 'bg-orange-100 text-orange-800' }}">
                        Sisa {{ $product->stock }}
                    </span>
                </div>
            @empty
                <p class="py-6 text-center text-slate-400 text-xs">Semua stok produk dalam kondisi aman.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
