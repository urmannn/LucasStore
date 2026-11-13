@extends('layouts.app')

@section('title', 'Keranjang Belanja — NusaStore')

@section('content')
<div class="flex items-center justify-between">
    <div>
        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Troli Belanja</span>
        <h1 class="text-2xl font-black text-slate-900">Keranjang Belanja Anda</h1>
    </div>
    <a href="{{ route('home') }}" class="text-xs font-bold text-emerald-700 hover:text-orange-500 transition">&larr; Lanjut Belanja</a>
</div>

@if($cartItems->isEmpty())
    <div class="mt-8 rounded-3xl border-2 border-dashed border-slate-300 bg-white p-12 text-center">
        <span class="text-4xl block mb-2">🛒</span>
        <p class="text-lg font-bold text-slate-800">Keranjang belanja Anda masih kosong</p>
        <p class="mt-1 text-sm text-slate-500">Temukan laptop, smartphone, tissue, pakaian, dan produk menarik lainnya.</p>
        <a href="{{ route('home') }}" class="mt-5 inline-block rounded-2xl bg-orange-500 px-6 py-3 text-sm font-black text-white hover:bg-orange-600 shadow-md transition">
            Jelajahi Katalog Produk
        </a>
    </div>
@else
    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <!-- Cart Items List -->
        <div class="space-y-4 lg:col-span-2">
            @foreach($cartItems as $item)
                <div class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white p-4 sm:p-5 shadow-xs sm:flex-row sm:items-center">
                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="h-24 w-28 shrink-0 rounded-2xl object-cover bg-slate-100 border border-slate-200">

                    <div class="flex-1">
                        <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider">{{ $item->product->category?->name }}</span>
                        <a href="{{ route('products.show', $item->product) }}" class="block text-base font-bold text-slate-900 hover:text-emerald-700 transition">
                            {{ $item->product->name }}
                        </a>
                        <p class="mt-1 text-sm font-semibold text-slate-500">
                            {{ $item->product->formatted_price }} &times; {{ $item->quantity }}
                        </p>
                        <p class="text-[11px] text-slate-400">Tersedia: {{ $item->product->stock }} unit</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ max(1, $item->product->stock) }}" class="w-18 rounded-xl border border-slate-300 px-2 py-1.5 text-center text-sm font-bold">
                            <button type="submit" class="rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-800 hover:bg-emerald-100 transition cursor-pointer">
                                Update
                            </button>
                        </form>

                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-xl border border-rose-200 px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                                Hapus
                            </button>
                        </form>
                    </div>

                    <div class="text-right sm:min-w-28">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Subtotal</span>
                        <p class="text-base font-black text-slate-900">{{ $item->formatted_subtotal }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Cart Summary -->
        <div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs sticky top-24">
                <h2 class="text-lg font-black text-slate-900">Ringkasan Pesanan</h2>

                <div class="mt-4 space-y-2.5 border-b border-slate-100 pb-4 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>Total Item</span>
                        <span class="font-bold text-slate-800">{{ $cartItems->sum('quantity') }} pcs</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Biaya Pengiriman</span>
                        <span class="text-emerald-700 font-extrabold">Gratis Ongkir</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Asuransi Transaksi</span>
                        <span class="text-emerald-700 font-extrabold">Gratis</span>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-500 uppercase tracking-wider font-semibold block">Total Tagihan</span>
                        <span class="text-2xl font-black text-orange-600">{{ \App\Support\Money::rupiah($total) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="mt-6 block w-full rounded-2xl bg-orange-500 px-5 py-3.5 text-center text-sm font-black text-white shadow-md hover:bg-orange-600 hover:shadow-orange-500/30 transition">
                    Lanjut ke Checkout &rarr;
                </a>

                <div class="mt-4 flex items-center justify-center gap-2 text-[11px] font-semibold text-slate-400">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    <span>Tersedia Pembayaran QRIS, VA Bank &amp; COD</span>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
