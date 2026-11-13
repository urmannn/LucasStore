@extends('layouts.app')

@section('title', 'Daftar Akun — NusaStore')

@section('content')
<div class="mx-auto max-w-lg py-6">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs sm:p-8">
        <div class="text-center">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-600 to-orange-500 text-lg font-black text-white shadow-sm mb-3">
                NS
            </span>
            <h1 class="text-2xl font-black text-slate-900">Buat Akun NusaStore</h1>
            <p class="mt-1 text-xs text-slate-500">Daftar sekarang untuk kemudahan berbelanja online.</p>
        </div>

        <form action="{{ route('register.store') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                </div>
                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700">No. WhatsApp / HP</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="0812..." class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Alamat Pengiriman (Opsional)</label>
                <textarea name="address" id="address" rows="2" placeholder="Alamat rumah atau kantor..." class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">{{ old('address') }}</textarea>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Kata Sandi</label>
                    <input type="password" name="password" id="password" required minlength="8" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                </div>
            </div>

            <button type="submit" class="w-full rounded-2xl bg-orange-500 px-5 py-3 text-sm font-black text-white shadow-md hover:bg-orange-600 transition cursor-pointer">
                Daftar Akun Baru
            </button>
        </form>

        <p class="mt-6 text-center text-xs font-semibold text-slate-600">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-extrabold text-emerald-700 hover:text-emerald-800">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
