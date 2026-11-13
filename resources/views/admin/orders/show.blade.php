@extends('layouts.admin')

@section('title', 'Detail Pesanan '.$order->order_number.' — Admin NusaStore')
@section('header', 'Detail & Status Pesanan')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-700 hover:text-orange-500 transition">&larr; Kembali ke Daftar Pesanan</a>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <!-- Order Items & Shipping Details -->
    <div class="space-y-6 lg:col-span-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <span class="font-mono text-sm font-black text-slate-900">{{ $order->order_number }}</span>
                <span class="rounded-full border px-2.5 py-0.5 text-xs font-bold {{ $order->status_badge }}">{{ $order->status_label }}</span>
            </div>

            <div class="mt-4 divide-y divide-slate-100 text-sm">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center gap-3">
                            @if($item->product)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="h-10 w-10 rounded-lg object-cover bg-slate-100 border border-slate-200">
                            @endif
                            <div>
                                <p class="font-bold text-slate-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-slate-500">{{ $item->quantity }} &times; {{ $item->formatted_price }}</p>
                            </div>
                        </div>
                        <span class="font-black text-slate-900">{{ $item->formatted_subtotal }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 flex items-center justify-between border-t border-slate-200 pt-4">
                <span class="font-bold text-slate-800">Total Tagihan</span>
                <span class="text-2xl font-black text-emerald-700">{{ $order->formatted_total }}</span>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs text-sm">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Informasi Pembeli &amp; Tujuan Kirim</h2>
            <p class="mt-2 text-base font-bold text-slate-900">{{ $order->shipping_name }} ({{ $order->shipping_phone }})</p>
            <p class="mt-1 text-slate-600 leading-relaxed">{{ $order->shipping_address }}</p>
            <div class="mt-3 pt-3 border-t border-slate-100 flex flex-wrap gap-4 text-xs text-slate-500">
                <span>Akun Email: <strong class="text-slate-700">{{ $order->user?->email }}</strong></span>
                <span>Metode Bayar: <strong class="text-slate-700">{{ $order->payment_method_label }}</strong></span>
            </div>
            @if($order->notes)
                <p class="mt-3 text-xs text-slate-600 bg-slate-50 p-3 rounded-2xl border border-slate-200">
                    <span class="font-bold">Catatan Pembeli:</span> {{ $order->notes }}
                </p>
            @endif
        </div>
    </div>

    <!-- Status Updater Card -->
    <div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Perbarui Status Transaksi</h2>

            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Status Pesanan</label>
                    <select name="status" id="status" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-xs font-bold focus:border-emerald-500 focus:outline-none cursor-pointer">
                        @foreach($statuses as $key => $meta)
                            <option value="{{ $key }}" @selected($order->status === $key)>{{ $meta['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="payment_status" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Status Pembayaran</label>
                    <select name="payment_status" id="payment_status" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-xs font-bold focus:border-emerald-500 focus:outline-none cursor-pointer">
                        @foreach($paymentStatuses as $key => $meta)
                            <option value="{{ $key }}" @selected($order->payment_status === $key)>{{ $meta['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="rounded-2xl bg-orange-50 border border-orange-200 p-3 text-xs text-orange-950">
                    💡 Mengubah status ke <strong>Dibatalkan</strong> akan secara otomatis mengembalikan stok semua produk terkait.
                </div>

                <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-3 text-xs font-black text-white hover:bg-emerald-700 transition cursor-pointer shadow-xs">
                    Simpan Perubahan Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
