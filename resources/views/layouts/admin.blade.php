<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel — NusaStore')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased selection:bg-orange-500 selection:text-white">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Admin Sidebar -->
        <aside class="w-full lg:w-64 shrink-0 bg-emerald-950 text-emerald-100">
            <div class="flex items-center justify-between border-b border-emerald-900 px-5 py-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 text-base font-black text-white">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-orange-500 text-xs font-black text-white shadow-xs">
                        NS
                    </span>
                    <span>Admin Panel</span>
                </a>
                <a href="{{ route('home') }}" class="text-xs text-orange-300 hover:text-white lg:hidden">Toko &rarr;</a>
            </div>
            <nav class="flex flex-wrap gap-1 p-3 lg:flex-col">
                <a href="{{ route('admin.dashboard') }}" class="rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-700 text-white shadow-xs' : 'text-emerald-200 hover:bg-emerald-900 hover:text-white' }}">
                    📊 Dashboard Ringkasan
                </a>
                <a href="{{ route('admin.categories.index') }}" class="rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-700 text-white shadow-xs' : 'text-emerald-200 hover:bg-emerald-900 hover:text-white' }}">
                    📁 Kelola Kategori
                </a>
                <a href="{{ route('admin.products.index') }}" class="rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.products.*') ? 'bg-emerald-700 text-white shadow-xs' : 'text-emerald-200 hover:bg-emerald-900 hover:text-white' }}">
                    📦 Kelola Produk
                </a>
                <a href="{{ route('admin.orders.index') }}" class="rounded-xl px-3.5 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.orders.*') ? 'bg-emerald-700 text-white shadow-xs' : 'text-emerald-200 hover:bg-emerald-900 hover:text-white' }}">
                    🛒 Kelola Pesanan
                </a>

                <div class="hidden lg:block my-3 border-t border-emerald-900/80"></div>

                <a href="{{ route('home') }}" class="hidden lg:flex items-center gap-2 rounded-xl px-3.5 py-2 text-xs font-bold text-orange-300 hover:bg-emerald-900 hover:text-orange-200 transition">
                    <span>&larr;</span> Kembali ke NusaStore
                </a>
                <form action="{{ route('logout') }}" method="POST" class="hidden lg:block mt-1">
                    @csrf
                    <button type="submit" class="w-full text-left rounded-xl px-3.5 py-2 text-xs font-bold text-rose-300 hover:bg-emerald-900 hover:text-rose-200 transition cursor-pointer">
                        Keluar Akun
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Admin Content Area -->
        <div class="flex-1 flex flex-col">
            <header class="border-b border-slate-200 bg-white px-6 py-4 flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">NusaStore Administration</span>
                    <h1 class="text-lg font-black text-slate-900">@yield('header', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3">
                    <span class="rounded-full bg-emerald-100 border border-emerald-200 px-3 py-1 text-xs font-bold text-emerald-800">
                        {{ auth()->user()->name }} (Admin)
                    </span>
                </div>
            </header>
            <main class="flex-1 p-6">
                <x-flash />
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
