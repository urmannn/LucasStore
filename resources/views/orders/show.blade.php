@extends('layouts.app')

@section('title', 'Pesanan '.$order->order_number.' — NusaStore')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3">
    <div>
        <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">&larr; Kembali ke Daftar Pesanan</a>
        <h1 class="mt-1 font-mono text-2xl font-black text-slate-900">{{ $order->order_number }}</h1>
        <p class="text-xs text-slate-500">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }} WIB</p>
    </div>

    <div class="flex flex-wrap items-center gap-2">
        <span class="rounded-full border px-3 py-1 text-xs font-bold {{ $order->status_badge }}">{{ $order->status_label }}</span>
        <span class="rounded-full border px-3 py-1 text-xs font-bold {{ $order->payment_status_badge }}">{{ $order->payment_status_label }}</span>
    </div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
            <h2 class="text-base font-bold text-slate-900">Daftar Produk yang Dipesan</h2>
            <div class="mt-4 divide-y divide-slate-100">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between gap-4 py-3.5">
                        <div class="flex items-center gap-3">
                            @if($item->product)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="h-12 w-12 rounded-xl object-cover bg-slate-100">
                            @endif
                            <div>
                                <p class="font-bold text-slate-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-slate-500">{{ $item->quantity }} &times; {{ $item->formatted_price }}</p>
                            </div>
                        </div>
                        <p class="text-sm font-extrabold text-slate-900">{{ $item->formatted_subtotal }}</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex items-center justify-between border-t border-slate-200 pt-4">
                <span class="font-bold text-slate-800">Total Pembayaran</span>
                <span class="text-2xl font-black text-emerald-700">{{ $order->formatted_total }}</span>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs text-sm">
            <h2 class="text-base font-bold text-slate-900">Alamat Pengiriman</h2>
            <p class="mt-2 font-bold text-slate-800">{{ $order->shipping_name }} ({{ $order->shipping_phone }})</p>
            <p class="mt-1 text-slate-600 leading-relaxed">{{ $order->shipping_address }}</p>
            @if($order->notes)
                <p class="mt-2 text-xs text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                    <span class="font-bold">Catatan:</span> {{ $order->notes }}
                </p>
            @endif
        </div>
    </div>

    <div class="space-y-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs text-sm">
            <h2 class="text-base font-bold text-slate-900">Status Pembayaran</h2>
            <p class="mt-2 text-slate-600">Metode: <span class="font-bold text-slate-800">{{ $order->payment_method_label }}</span></p>

            @if($order->paid_at)
                <div class="mt-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-xs text-emerald-900">
                    <p class="font-bold text-emerald-800 text-sm flex items-center gap-1.5">
                        <span>✓</span> Pembayaran Lunas
                    </p>
                    <p class="mt-1">Dikonfirmasi pada {{ $order->paid_at->format('d M Y, H:i') }} WIB.</p>
                </div>
            @endif

            @if($order->canBePaid())
                <div class="mt-4 rounded-2xl border border-orange-200 bg-orange-50/70 p-4 text-xs text-orange-950">
                    <p class="font-bold text-orange-900">Pesanan Menunggu Pembayaran</p>
                    <p class="mt-1">Silakan buka halaman simulator pembayaran untuk menyelesaikan pembayaran dengan QRIS atau Virtual Account.</p>
                </div>

                <a href="{{ route('orders.payment', $order) }}" class="mt-4 block w-full text-center rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-extrabold text-white shadow-md hover:bg-emerald-700 transition cursor-pointer">
                    💳 Buka Simulator Pembayaran (Mock)
                </a>

                <form action="{{ route('orders.pay', $order) }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full rounded-2xl border border-orange-300 bg-orange-50 px-4 py-2 text-xs font-bold text-orange-700 hover:bg-orange-100 transition cursor-pointer">
                        ⚡ Bayar Cepat Instan
                    </button>
                </form>
            @endif

            @if($order->canBeCancelled())
                <form action="{{ route('orders.cancel', $order) }}" method="POST" class="mt-4 border-t border-slate-100 pt-3" onsubmit="return confirm('Batalkan pesanan ini? Stok produk akan dikembalikan otomatis.')">
                    @csrf
                    <button type="submit" class="w-full rounded-xl border border-rose-200 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                        Batalkan Pesanan
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
