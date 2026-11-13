@extends('layouts.app')

@section('title', 'Pesanan Saya — NusaStore')

@section('content')
<div class="flex items-center justify-between">
    <div>
        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Aktivitas Belanja</span>
        <h1 class="text-2xl font-black text-slate-900">Riwayat Pesanan Saya</h1>
    </div>
    <a href="{{ route('home') }}" class="text-xs font-bold text-emerald-700 hover:text-orange-500 transition">&larr; Belanja Lagi</a>
</div>

@if($orders->isEmpty())
    <div class="mt-8 rounded-3xl border-2 border-dashed border-slate-300 bg-white p-12 text-center">
        <span class="text-4xl block mb-2">📦</span>
        <p class="text-base font-bold text-slate-800">Anda belum memiliki pesanan</p>
        <p class="mt-1 text-sm text-slate-500">Mulai belanja berbagai produk pilihan terbaik di NusaStore.</p>
        <a href="{{ route('home') }}" class="mt-5 inline-block rounded-2xl bg-orange-500 px-6 py-3 text-sm font-black text-white hover:bg-orange-600 shadow-md transition">
            Lihat Katalog Produk
        </a>
    </div>
@else
    <div class="mt-6 space-y-4">
        @foreach($orders as $order)
            <div class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white p-5 shadow-xs sm:flex-row sm:items-center sm:justify-between hover:border-emerald-300 transition">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="font-mono text-sm font-black text-slate-900">{{ $order->order_number }}</span>
                        <span class="rounded-full border px-2.5 py-0.5 text-xs font-bold {{ $order->status_badge }}">
                            {{ $order->status_label }}
                        </span>
                        <span class="rounded-full border px-2.5 py-0.5 text-xs font-bold {{ $order->payment_status_badge }}">
                            {{ $order->payment_status_label }}
                        </span>
                    </div>

                    <p class="mt-2 text-xs font-semibold text-slate-500">
                        {{ $order->created_at->format('d M Y, H:i') }} WIB &bull; {{ $order->items_count }} jenis item &bull; {{ $order->payment_method_label }}
                    </p>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4 sm:justify-end">
                    <div class="text-left sm:text-right">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Total</span>
                        <p class="text-lg font-black text-slate-900">{{ $order->formatted_total }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        @if($order->canBePaid())
                            <a href="{{ route('orders.payment', $order) }}" class="rounded-xl bg-orange-500 px-3.5 py-2 text-xs font-black text-white shadow-xs hover:bg-orange-600 transition">
                                💳 Bayar
                            </a>
                        @endif

                        <a href="{{ route('orders.show', $order) }}" class="rounded-xl border border-slate-200 px-3.5 py-2 text-xs font-bold text-slate-700 hover:border-emerald-500 hover:text-emerald-700 hover:bg-emerald-50/50 transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>
@endif
@endsection
