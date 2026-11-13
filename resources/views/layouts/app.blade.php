<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NusaStore — Belanja Online Mudah, Cepat & Terpercaya')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-slate-50 text-slate-800 antialiased selection:bg-orange-500 selection:text-white">
    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-emerald-700 via-green-700 to-emerald-800 text-white px-4 py-1.5 text-xs font-semibold text-center tracking-wide">
        <span>🎉 Gratis Ongkir ke Seluruh Indonesia &bull; Promo Spesial Pelanggan Baru!</span>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 border-b border-emerald-100 bg-white/95 backdrop-blur shadow-2xs">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-lg font-black tracking-tight text-slate-900 group">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600 to-orange-500 text-sm font-black text-white shadow-sm transition group-hover:scale-105">
                        NS
                    </span>
                    <span>
                        <span class="text-emerald-700">Nusa</span><span class="text-orange-500">Store</span>
                    </span>
                </a>
                <nav class="hidden md:flex items-center gap-5 text-sm font-semibold text-slate-600">
                    <a href="{{ route('home') }}" class="hover:text-emerald-700 transition {{ request()->routeIs('home') ? 'text-emerald-700 font-extrabold border-b-2 border-emerald-600 pb-0.5' : '' }}">
                        Katalog Produk
                    </a>
                    @auth
                        <a href="{{ route('orders.index') }}" class="hover:text-emerald-700 transition {{ request()->routeIs('orders.*') ? 'text-emerald-700 font-extrabold border-b-2 border-emerald-600 pb-0.5' : '' }}">
                            Pesanan Saya
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-50 border border-emerald-200 px-3 py-1 text-xs font-bold text-emerald-800 hover:bg-emerald-100 transition">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                Admin Panel
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    @php $cartQty = auth()->user()->cartQuantity(); @endphp
                    <a href="{{ route('cart.index') }}" class="relative inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-bold text-slate-700 hover:border-emerald-400 hover:text-emerald-700 transition shadow-2xs">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <span class="hidden sm:inline">Keranjang</span>
                        @if($cartQty > 0)
                            <span class="inline-flex min-w-5 h-5 items-center justify-center rounded-full bg-orange-500 px-1.5 text-xs font-black text-white shadow-xs animate-pulse">{{ $cartQty }}</span>
                        @endif
                    </a>

                    <a href="{{ route('profile.edit') }}" class="hidden sm:inline-flex items-center rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-800 transition">
                        👤 {{ auth()->user()->name }}
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-xl border border-slate-200 px-3.5 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 hover:text-rose-600 transition cursor-pointer">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl px-4 py-2 text-sm font-bold text-slate-700 hover:text-emerald-700 hover:bg-emerald-50 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-orange-500 px-4 py-2 text-sm font-bold text-white shadow-xs hover:bg-orange-600 transition">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <x-flash />
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-600 to-orange-500 text-xs font-black text-white">
                        NS
                    </span>
                    <span class="font-extrabold text-base">
                        <span class="text-emerald-700">Nusa</span><span class="text-orange-500">Store</span>
                    </span>
                    <span class="text-xs text-slate-400">| Platform E-Commerce Modern</span>
                </div>
                <div class="flex flex-wrap items-center gap-6 text-sm font-semibold text-slate-600">
                    <a href="{{ route('home') }}" class="hover:text-emerald-700 transition">Katalog</a>
                    @auth
                        <a href="{{ route('orders.index') }}" class="hover:text-emerald-700 transition">Pesanan</a>
                        <a href="{{ route('profile.edit') }}" class="hover:text-emerald-700 transition">Profil</a>
                    @endauth
                </div>
            </div>
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-400">
                <p>&copy; {{ date('Y') }} NusaStore. Dibuat dengan tema warna Hijau &amp; Orange menggunakan Laravel &amp; Tailwind CSS.</p>
                <div class="flex items-center gap-2">
                    <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span class="text-emerald-700 font-semibold">Payment Mock Sandbox Active</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
