@extends('layouts.app')

@section('title', 'NusaStore — Belanja Online Produk Real Berkualitas')

@section('content')
<!-- Hero Banner Green & Orange -->
<section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-800 via-emerald-700 to-green-900 px-6 py-10 text-white shadow-md sm:px-10 sm:py-14">
    <!-- Decorative warm orange glow elements -->
    <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-orange-500/25 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-emerald-400/20 blur-3xl"></div>

    <div class="relative z-10 max-w-2xl">
        <div class="inline-flex items-center gap-2 rounded-full bg-orange-500/20 border border-orange-400/40 px-3.5 py-1 text-xs font-bold text-orange-200 tracking-wide backdrop-blur-xs">
            <span class="inline-block h-2 w-2 rounded-full bg-orange-400 animate-pulse"></span>
            Katalog Produk Nyata &bull; Dilengkapi Mock Payment Gateway
        </div>

        <h1 class="mt-4 text-3xl font-black tracking-tight sm:text-4xl lg:text-5xl leading-tight">
            Pusat Belanja Pilihan Terbaik dengan Harga Terjangkau
        </h1>

        <p class="mt-4 text-sm text-emerald-100 sm:text-base leading-relaxed">
            Dapatkan produk laptop, smartphone, tissue harian, pakaian, aksesoris premium, hingga perlengkapan olahraga dengan kemudahan checkout dan simulator pembayaran lengkap.
        </p>

        <div class="mt-7 flex flex-wrap items-center gap-3.5">
            <a href="#katalog" class="rounded-2xl bg-orange-500 px-6 py-3 text-sm font-extrabold text-white shadow-lg hover:bg-orange-600 hover:shadow-orange-500/30 transition transform hover:-translate-y-0.5">
                🛒 Mulai Belanja Sekarang
            </a>
            @guest
                <a href="{{ route('login') }}" class="rounded-2xl border-2 border-white/30 bg-white/10 backdrop-blur-xs px-5 py-2.5 text-sm font-bold text-white hover:bg-white/20 transition">
                    Masuk Akun Demo
                </a>
            @endguest
        </div>
    </div>
</section>

<!-- Product Catalog Section -->
<section id="katalog" class="mt-10">
    <!-- Search & Filter Controls -->
    <div class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white p-4 sm:p-5 shadow-xs lg:flex-row lg:items-center lg:justify-between">
        <form action="{{ route('home') }}" method="GET" class="flex flex-1 flex-col gap-3 sm:flex-row sm:items-center">
            @if($activeCategory !== '')
                <input type="hidden" name="category" value="{{ $activeCategory }}">
            @endif

            <div class="relative flex-1">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari laptop, handphone, tissue, pakaian..." class="w-full rounded-2xl border border-slate-300 py-2.5 px-4 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
            </div>

            <select name="sort" onchange="this.form.submit()" class="rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none cursor-pointer">
                <option value="latest" @selected($sortKey === 'latest')>Terbaru</option>
                <option value="price_asc" @selected($sortKey === 'price_asc')>Harga Termurah</option>
                <option value="price_desc" @selected($sortKey === 'price_desc')>Harga Termahal</option>
                <option value="name_asc" @selected($sortKey === 'name_asc')>Nama A - Z</option>
            </select>

            <button type="submit" class="rounded-2xl bg-emerald-700 px-6 py-2.5 text-sm font-extrabold text-white hover:bg-emerald-800 transition cursor-pointer shadow-xs">
                Cari
            </button>

            @if($search !== '' || $activeCategory !== '')
                <a href="{{ route('home') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-center text-sm font-bold text-slate-600 hover:bg-slate-50 transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Category Pills Filter -->
    <div class="mt-4 flex flex-wrap items-center gap-2">
        <a href="{{ route('home', array_filter(['q' => $search, 'sort' => $sortKey])) }}" class="rounded-full px-4 py-1.5 text-xs font-bold transition shadow-2xs {{ $activeCategory === '' ? 'bg-emerald-600 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:border-orange-400 hover:text-orange-600' }}">
            Semua Produk
        </a>
        @foreach($categories as $category)
            <a href="{{ route('home', array_filter(['category' => $category->slug, 'q' => $search, 'sort' => $sortKey])) }}" class="rounded-full px-4 py-1.5 text-xs font-bold transition shadow-2xs {{ $activeCategory === $category->slug ? 'bg-emerald-600 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:border-orange-400 hover:text-orange-600' }}">
                {{ $category->name }} ({{ $category->products_count }})
            </a>
        @endforeach
    </div>

    <!-- Products Grid -->
    @if($products->isEmpty())
        <div class="mt-8 rounded-3xl border-2 border-dashed border-slate-300 bg-white p-12 text-center">
            <span class="text-4xl block mb-2">🔍</span>
            <p class="text-base font-bold text-slate-800">Produk Tidak Ditemukan</p>
            <p class="mt-1 text-sm text-slate-500">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
            <a href="{{ route('home') }}" class="mt-5 inline-block rounded-2xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-emerald-700 transition">
                Kembali ke Semua Produk
            </a>
        </div>
    @else
        <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @endif
</section>
@endsection
