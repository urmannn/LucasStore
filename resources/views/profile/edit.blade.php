@extends('layouts.app')

@section('title', 'Profil Saya — NusaStore')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs sm:p-8">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Pengaturan Akun</span>
            <h1 class="text-2xl font-black text-slate-900">Profil &amp; Alamat Saya</h1>
            <p class="mt-1 text-xs text-slate-500">Perbarui informasi kontak dan alamat pengiriman Anda.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Alamat Email</label>
                <input type="email" value="{{ $user->email }}" disabled class="mt-1 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-500 cursor-not-allowed">
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                </div>
                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Nomor Telepon / WA</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="0812..." class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Alamat Pengiriman Utama</label>
                <textarea name="address" id="address" rows="3" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none leading-relaxed">{{ old('address', $user->address) }}</textarea>
            </div>

            <hr class="border-slate-100 my-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Ubah Kata Sandi (Opsional)</h3>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Kata Sandi Baru</label>
                    <input type="password" name="password" id="password" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="rounded-2xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-md hover:bg-emerald-700 transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
