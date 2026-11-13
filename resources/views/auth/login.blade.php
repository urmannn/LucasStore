@extends('layouts.app')

@section('title', 'Masuk Akun — NusaStore')

@section('content')
<div class="mx-auto max-w-md py-6">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs sm:p-8">
        <div class="text-center">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-600 to-orange-500 text-lg font-black text-white shadow-sm mb-3">
                NS
            </span>
            <h1 class="text-2xl font-black text-slate-900">Masuk ke NusaStore</h1>
            <p class="mt-1 text-xs text-slate-500">Kelola keranjang belanja dan pantau pesanan Anda.</p>
        </div>

        <form action="{{ route('login.attempt') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Kata Sandi</label>
                <input type="password" name="password" id="password" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
            </div>

            <label class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                Ingat status login saya
            </label>

            <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-extrabold text-white shadow-md hover:bg-emerald-700 transition cursor-pointer">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50/70 p-4 text-xs text-emerald-950">
            <p class="font-extrabold text-emerald-900 mb-1 flex items-center gap-1">
                <span>🔑</span> Akun Demo Cepat:
            </p>
            <p>Admin: <code class="font-mono bg-white px-1.5 py-0.5 rounded border border-emerald-200">admin@example.com</code> / <code class="font-mono bg-white px-1.5 py-0.5 rounded border border-emerald-200">password</code></p>
            <p class="mt-1">Customer: <code class="font-mono bg-white px-1.5 py-0.5 rounded border border-emerald-200">customer@example.com</code> / <code class="font-mono bg-white px-1.5 py-0.5 rounded border border-emerald-200">password</code></p>
        </div>

        <p class="mt-6 text-center text-xs font-semibold text-slate-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-extrabold text-orange-600 hover:text-orange-700">Daftar sekarang</a>
        </p>
    </div>
</div>
@endsection
