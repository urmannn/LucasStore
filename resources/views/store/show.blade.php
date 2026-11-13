@extends('layouts.app')

@section('title', $product->name.' — NusaStore')

@section('content')
<nav class="mb-6 flex items-center gap-2 text-xs font-semibold text-slate-500">
    <a href="{{ route('home') }}" class="hover:text-emerald-700">Katalog</a>
    <span>/</span>
    @if($product->category)
        <a href="{{ route('home', ['category' => $product->category->slug]) }}" class="hover:text-emerald-700">{{ $product->category->name }}</a>
        <span>/</span>
    @endif
    <span class="text-slate-900 font-bold truncate">{{ $product->name }}</span>
</nav>

<div class="grid gap-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-xs lg:grid-cols-2 lg:p-10">
    <!-- Real Product Image Display -->
    <div class="overflow-hidden rounded-3xl bg-slate-100 aspect-[4/3] border border-slate-200 shadow-2xs">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
    </div>

    <!-- Product Details -->
    <div class="flex flex-col">
        <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-200 px-3 py-1 text-xs font-bold text-emerald-800">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
            {{ $product->category?->name ?? 'Kategori Umum' }}
        </span>

        <h1 class="mt-3 text-2xl font-black text-slate-900 sm:text-3xl lg:text-4xl leading-tight">
            {{ $product->name }}
        </h1>

        <!-- Price -->
        <div class="mt-4 rounded-2xl bg-orange-50/70 border border-orange-200 p-4">
            <span class="text-xs font-bold text-orange-800 uppercase tracking-wider block">Harga Spesial</span>
            <p class="text-3xl sm:text-4xl font-black text-orange-600 mt-1">{{ $product->formatted_price }}</p>
        </div>

        <!-- Stock Status -->
        <div class="mt-4 flex items-center gap-3 text-xs font-bold">
            @if($product->stock > 0)
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 border border-emerald-200 px-3 py-1 text-emerald-800">
                    <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                    Stok Tersedia: {{ $product->stock }} unit
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 border border-rose-200 px-3 py-1 text-rose-800">
                    Stok Habis
                </span>
            @endif
            <span class="text-slate-400">&bull; 100% Produk Original Bergaransi</span>
        </div>

        <!-- Description -->
        <div class="mt-6 border-t border-slate-100 pt-5">
            <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Deskripsi Lengkap</h2>
            <p class="mt-2.5 whitespace-pre-line text-sm leading-relaxed text-slate-600">
                {{ $product->description ?: 'Belum ada deskripsi tambahan untuk produk ini.' }}
            </p>
        </div>

        <!-- Action / Add to Cart Form -->
        <div class="mt-auto pt-8">
            @auth
                <form action="{{ route('cart.store') }}" method="POST" class="flex flex-wrap items-center gap-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="flex items-center rounded-2xl border border-slate-300 bg-white">
                        <label for="quantity" class="px-3.5 text-xs font-bold text-slate-500">Jumlah</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ max(1, $product->stock) }}" @disabled($product->stock < 1) class="w-20 border-l border-slate-200 py-3 px-3 text-center text-sm font-black focus:outline-none">
                    </div>

                    <button type="submit" @disabled($product->stock < 1) class="flex-1 rounded-2xl bg-orange-500 px-6 py-3.5 text-sm font-black text-white shadow-md hover:bg-orange-600 hover:shadow-orange-500/30 disabled:cursor-not-allowed disabled:bg-slate-300 transition cursor-pointer">
                        + Tambah ke Keranjang
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="inline-block w-full rounded-2xl bg-orange-500 px-6 py-3.5 text-center text-sm font-black text-white shadow-md hover:bg-orange-600 transition">
                    Masuk Akun untuk Membeli
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->isNotEmpty())
    <section class="mt-14">
        <div class="flex items-center justify-between mb-5">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Rekomendasi</span>
                <h2 class="text-xl font-black text-slate-900">Produk Serupa Pilihan</h2>
            </div>
            <a href="{{ route('home', ['category' => $product->category?->slug]) }}" class="text-xs font-bold text-emerald-700 hover:text-orange-500 transition">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($relatedProducts as $related)
                <x-product-card :product="$related" />
            @endforeach
        </div>
    </section>
@endif
@endsection
