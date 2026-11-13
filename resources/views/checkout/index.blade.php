@extends('layouts.app')

@section('title', 'Checkout Pesanan — NusaStore')

@section('content')
<div class="flex items-center justify-between">
    <div>
        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Tahap Akhir</span>
        <h1 class="text-2xl font-black text-slate-900">Checkout &amp; Pembayaran</h1>
    </div>
    <a href="{{ route('cart.index') }}" class="text-xs font-bold text-emerald-700 hover:text-orange-500 transition">&larr; Kembali ke Keranjang</a>
</div>

<form action="{{ route('checkout.store') }}" method="POST" class="mt-6 grid gap-6 lg:grid-cols-3">
    @csrf
    <!-- Shipping & Payment Form -->
    <div class="space-y-6 lg:col-span-2">
        <!-- Shipping Address Card -->
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
            <div class="flex items-center gap-2 mb-4">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-100 text-xs font-black text-emerald-800">1</span>
                <h2 class="text-base font-extrabold text-slate-900">Informasi Penerima &amp; Alamat Pengiriman</h2>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="shipping_name" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Nama Penerima</label>
                    <input type="text" name="shipping_name" id="shipping_name" value="{{ old('shipping_name', $user->name) }}" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                </div>
                <div>
                    <label for="shipping_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone', $user->phone) }}" required placeholder="0812..." class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
                </div>
            </div>

            <div class="mt-4">
                <label for="shipping_address" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Alamat Lengkap Pengiriman</label>
                <textarea name="shipping_address" id="shipping_address" rows="3" required placeholder="Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten..." class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none leading-relaxed">{{ old('shipping_address', $user->address) }}</textarea>
            </div>

            <div class="mt-4">
                <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Catatan untuk Kurir (Opsional)</label>
                <input type="text" name="notes" id="notes" value="{{ old('notes') }}" placeholder="Contoh: Titip ke satpam jika sedang tidak di rumah" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
            </div>
        </div>

        <!-- Payment Method Selection Card -->
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
            <div class="flex items-center gap-2 mb-4">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-orange-100 text-xs font-black text-orange-800">2</span>
                <h2 class="text-base font-extrabold text-slate-900">Pilih Metode Pembayaran (Mock Sandbox)</h2>
            </div>

            <div class="space-y-3">
                @foreach($paymentMethods as $key => $label)
                    <label class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 p-4 hover:border-emerald-500 hover:bg-emerald-50/30 transition cursor-pointer has-checked:border-emerald-600 has-checked:bg-emerald-50/50">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="{{ $key }}" @checked(old('payment_method', 'ewallet') === $key) class="text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                            <div>
                                <span class="text-sm font-bold text-slate-900 block">{{ $label }}</span>
                                <span class="text-xs text-slate-500">
                                    @if($key === 'ewallet')
                                        Scan otomatis QRIS via GoPay, OVO, Dana, ShopeePay, BCA Mobile
                                    @elseif($key === 'bank_transfer')
                                        Transfer Virtual Account dengan nomor unik otomatis
                                    @else
                                        Bayar uang tunai kepada kurir saat pesanan sampai
                                    @endif
                                </span>
                            </div>
                        </div>
                        <span class="rounded-lg bg-white border border-slate-200 px-2 py-0.5 text-[10px] font-bold text-emerald-800 uppercase">
                            Instan
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Order Summary Sidebar -->
    <div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs sticky top-24">
            <h2 class="text-base font-black text-slate-900">Ringkasan Pembelian</h2>

            <ul class="mt-4 divide-y divide-slate-100 text-sm max-h-72 overflow-y-auto pr-1">
                @foreach($cartItems as $item)
                    <li class="flex items-center justify-between gap-3 py-3">
                        <div class="flex items-center gap-2.5">
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="h-10 w-10 shrink-0 rounded-lg object-cover bg-slate-100 border border-slate-200">
                            <div>
                                <p class="font-bold text-slate-900 line-clamp-1 text-xs">{{ $item->product->name }}</p>
                                <p class="text-[11px] text-slate-500">{{ $item->quantity }} &times; {{ $item->product->formatted_price }}</p>
                            </div>
                        </div>
                        <span class="font-black text-slate-900 text-xs shrink-0">{{ $item->formatted_subtotal }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4 space-y-2 border-t border-slate-100 pt-4 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal Produk</span>
                    <span class="font-bold text-slate-800">{{ \App\Support\Money::rupiah($total) }}</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Ongkos Kirim</span>
                    <span class="text-emerald-700 font-extrabold">Gratis (Promo)</span>
                </div>
            </div>

            <div class="mt-4 border-t border-slate-200 pt-4 flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider font-bold text-slate-400 block">Total Tagihan</span>
                    <span class="text-2xl font-black text-orange-600">{{ \App\Support\Money::rupiah($total) }}</span>
                </div>
            </div>

            <button type="submit" class="mt-6 w-full rounded-2xl bg-orange-500 px-5 py-3.5 text-sm font-black text-white shadow-md hover:bg-orange-600 hover:shadow-orange-500/30 transition cursor-pointer">
                Buat Pesanan &amp; Lanjut Bayar &rarr;
            </button>

            <p class="mt-3 text-[11px] text-center text-slate-400">
                🔒 Pembayaran aman dengan Simulator Sandbox NusaStore
            </p>
        </div>
    </div>
</form>
@endsection
