@extends('layouts.app')

@section('title', 'Pembayaran '.$order->order_number.' — NusaStore')

@section('content')
<div class="mx-auto max-w-4xl py-2">
    <!-- Sandbox Notice Header -->
    <div class="mb-6 rounded-2xl border border-orange-200 bg-gradient-to-r from-orange-50 via-amber-50 to-emerald-50 p-4 sm:p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-white font-black text-lg">
                    ⚡
                </span>
                <div>
                    <h2 class="font-bold text-slate-900 text-base">Payment Gateway Mock (Sandbox Mode)</h2>
                    <p class="text-xs text-slate-600">Halaman ini adalah simulator transaksi e-commerce untuk pengujian dan demo portofolio.</p>
                </div>
            </div>
            <div class="inline-flex items-center gap-2 rounded-xl bg-white/80 border border-orange-200 px-3 py-1.5 text-xs font-semibold text-orange-700">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                </span>
                <span>Simulator Siap Digunakan</span>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Main Payment Card -->
        <div class="space-y-6 lg:col-span-2">
            <!-- Order summary & Timer -->
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-4">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nomor Pesanan</span>
                        <p class="font-mono text-base font-bold text-slate-900">{{ $order->order_number }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sisa Waktu Pembayaran</span>
                        <p id="countdown-timer" class="font-mono text-base font-extrabold text-orange-600">23:59:45</p>
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap items-baseline justify-between gap-2">
                    <div>
                        <span class="text-xs text-slate-500">Total yang harus dibayar:</span>
                        <p class="text-3xl font-black text-emerald-700 sm:text-4xl">{{ $order->formatted_total }}</p>
                    </div>
                    <span class="rounded-full bg-orange-100 border border-orange-200 px-3 py-1 text-xs font-bold text-orange-800">
                        {{ $order->payment_method_label }}
                    </span>
                </div>

                <!-- Payment Method Specific View -->
                <div class="mt-6 border-t border-slate-100 pt-6">
                    @if($order->payment_method === 'ewallet')
                        <!-- QRIS View -->
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-6 text-center">
                            <div class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-1 text-xs font-bold text-white tracking-wider">
                                QRIS STANDAR PEMBAYARAN NASIONAL
                            </div>

                            <p class="mt-3 text-xs text-slate-600">Scan QR berikut menggunakan aplikasi mobile banking atau e-wallet pilihan Anda.</p>

                            <!-- Realistic QR Code Graphic with Logo -->
                            <div class="mx-auto mt-4 w-60 rounded-2xl bg-white p-4 shadow-sm border border-slate-200">
                                <svg class="w-full h-auto aspect-square" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- QR pattern -->
                                    <rect width="200" height="200" fill="white"/>
                                    <!-- Corner 1 -->
                                    <rect x="15" y="15" width="45" height="45" rx="6" fill="#047857"/>
                                    <rect x="23" y="23" width="29" height="29" rx="3" fill="white"/>
                                    <rect x="29" y="29" width="17" height="17" rx="2" fill="#F97316"/>
                                    <!-- Corner 2 -->
                                    <rect x="140" y="15" width="45" height="45" rx="6" fill="#047857"/>
                                    <rect x="148" y="23" width="29" height="29" rx="3" fill="white"/>
                                    <rect x="154" y="29" width="17" height="17" rx="2" fill="#F97316"/>
                                    <!-- Corner 3 -->
                                    <rect x="15" y="140" width="45" height="45" rx="6" fill="#047857"/>
                                    <rect x="23" y="148" width="29" height="29" rx="3" fill="white"/>
                                    <rect x="29" y="154" width="17" height="17" rx="2" fill="#F97316"/>
                                    <!-- Data matrix mock -->
                                    <rect x="70" y="20" width="8" height="8" fill="#1E293B"/>
                                    <rect x="85" y="20" width="8" height="8" fill="#1E293B"/>
                                    <rect x="100" y="20" width="8" height="8" fill="#1E293B"/>
                                    <rect x="115" y="20" width="8" height="8" fill="#1E293B"/>
                                    <rect x="70" y="35" width="15" height="8" fill="#1E293B"/>
                                    <rect x="95" y="35" width="8" height="15" fill="#1E293B"/>
                                    <rect x="115" y="35" width="15" height="8" fill="#1E293B"/>
                                    <rect x="70" y="50" width="8" height="15" fill="#1E293B"/>
                                    <rect x="110" y="50" width="12" height="12" fill="#1E293B"/>
                                    <!-- Middle center logo -->
                                    <rect x="72" y="72" width="56" height="56" rx="12" fill="#047857"/>
                                    <rect x="76" y="76" width="48" height="48" rx="10" fill="#F97316"/>
                                    <text x="100" y="106" font-family="system-ui, sans-serif" font-size="16" font-weight="900" fill="white" text-anchor="middle">NS</text>
                                    <!-- Bottom matrix -->
                                    <rect x="70" y="140" width="12" height="12" fill="#1E293B"/>
                                    <rect x="90" y="140" width="8" height="20" fill="#1E293B"/>
                                    <rect x="105" y="140" width="15" height="8" fill="#1E293B"/>
                                    <rect x="130" y="140" width="8" height="12" fill="#1E293B"/>
                                    <rect x="150" y="140" width="20" height="8" fill="#1E293B"/>
                                    <rect x="140" y="90" width="15" height="8" fill="#1E293B"/>
                                    <rect x="165" y="90" width="10" height="20" fill="#1E293B"/>
                                    <rect x="140" y="115" width="20" height="8" fill="#1E293B"/>
                                    <rect x="170" y="115" width="12" height="12" fill="#1E293B"/>
                                    <rect x="20" y="90" width="15" height="8" fill="#1E293B"/>
                                    <rect x="45" y="90" width="12" height="12" fill="#1E293B"/>
                                    <rect x="20" y="115" width="20" height="8" fill="#1E293B"/>
                                    <rect x="50" y="115" width="12" height="12" fill="#1E293B"/>
                                    <rect x="70" y="165" width="20" height="8" fill="#1E293B"/>
                                    <rect x="100" y="165" width="15" height="15" fill="#1E293B"/>
                                    <rect x="125" y="165" width="8" height="15" fill="#1E293B"/>
                                    <rect x="145" y="160" width="30" height="8" fill="#1E293B"/>
                                    <rect x="150" y="175" width="15" height="10" fill="#1E293B"/>
                                </svg>
                            </div>

                            <p class="mt-3 text-xs font-mono text-slate-500">NMID: ID1020304050607 &bull; NusaStore Official</p>

                            <!-- Supported brands -->
                            <div class="mt-4 flex flex-wrap items-center justify-center gap-2 text-xs font-semibold text-slate-600">
                                <span class="rounded-lg bg-white border border-slate-200 px-2.5 py-1">GoPay</span>
                                <span class="rounded-lg bg-white border border-slate-200 px-2.5 py-1">OVO</span>
                                <span class="rounded-lg bg-white border border-slate-200 px-2.5 py-1">DANA</span>
                                <span class="rounded-lg bg-white border border-slate-200 px-2.5 py-1">ShopeePay</span>
                                <span class="rounded-lg bg-white border border-slate-200 px-2.5 py-1">BCA Mobile</span>
                                <span class="rounded-lg bg-white border border-slate-200 px-2.5 py-1">Livin' Mandiri</span>
                            </div>
                        </div>
                    @elseif($order->payment_method === 'bank_transfer')
                        <!-- Virtual Account View -->
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-6">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase text-emerald-800">Virtual Account Bank Mandiri / BCA / BRI</span>
                                <span class="rounded-md bg-emerald-600 px-2 py-0.5 text-[11px] font-bold text-white">Verifikasi Otomatis</span>
                            </div>

                            <div class="mt-4 rounded-xl border border-slate-200 bg-white p-4 shadow-2xs">
                                <span class="text-xs text-slate-500">Nomor Virtual Account (VA):</span>
                                <div class="mt-1 flex items-center justify-between gap-3">
                                    <span id="va-number" class="font-mono text-xl sm:text-2xl font-black tracking-wider text-slate-900">{{ $order->mock_virtual_account_number }}</span>
                                    <button type="button" onclick="copyVaNumber()" class="inline-flex items-center gap-1.5 rounded-xl bg-orange-500 px-3.5 py-2 text-xs font-bold text-white hover:bg-orange-600 transition cursor-pointer">
                                        <span id="copy-icon">📋</span>
                                        <span id="copy-text">Salin VA</span>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-5 space-y-2 text-xs text-slate-600">
                                <p class="font-semibold text-slate-800">Petunjuk Transfer m-Banking:</p>
                                <ol class="list-decimal list-inside space-y-1">
                                    <li>Buka aplikasi m-Banking Anda (BCA / Mandiri / BRI / BNI).</li>
                                    <li>Pilih menu <strong>Transfer &gt; Virtual Account</strong>.</li>
                                    <li>Masukkan Nomor VA <strong class="font-mono">{{ $order->mock_virtual_account_number }}</strong>.</li>
                                    <li>Pastikan nama merchant tertera <strong>NusaStore - {{ $order->shipping_name }}</strong> dengan total nominal yang pas.</li>
                                    <li>Konfirmasi PIN transaksi Anda. Pembayaran akan terverifikasi seketika.</li>
                                </ol>
                            </div>
                        </div>
                    @else
                        <!-- COD View -->
                        <div class="rounded-2xl border border-orange-200 bg-orange-50/60 p-6">
                            <h3 class="text-sm font-bold text-orange-900">Pembayaran di Tempat (Cash on Delivery)</h3>
                            <p class="mt-2 text-xs leading-relaxed text-slate-700">
                                Pesanan Anda sedang dipersiapkan untuk pengiriman ke alamat: <br>
                                <strong class="text-slate-900">{{ $order->shipping_address }}</strong>.
                            </p>
                            <p class="mt-2 text-xs text-slate-700">
                                Mohon siapkan uang tunai pas sebesar <strong class="text-emerald-700 font-bold">{{ $order->formatted_total }}</strong> saat kurir tiba.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Items summary accordion -->
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
                <h3 class="font-bold text-slate-900 text-sm">Rincian Produk dalam Pesanan ini</h3>
                <div class="mt-3 divide-y divide-slate-100 text-sm">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between py-2.5">
                            <div class="flex items-center gap-3">
                                @if($item->product)
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="h-10 w-10 rounded-lg object-cover bg-slate-100">
                                @endif
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $item->product_name }}</p>
                                    <p class="text-xs text-slate-500">{{ $item->quantity }} &times; {{ $item->formatted_price }}</p>
                                </div>
                            </div>
                            <span class="font-bold text-slate-900">{{ $item->formatted_subtotal }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Action / Simulator Controls -->
        <div class="space-y-4">
            <div class="rounded-3xl border-2 border-emerald-500 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                    <h3 class="font-black text-slate-900 text-base">Kontrol Simulator (Mock)</h3>
                </div>
                <p class="mt-1 text-xs text-slate-500">Pilih skenario pembayaran di bawah untuk menguji alur aplikasi secara instan.</p>

                <!-- Form Pay Success -->
                <form action="{{ route('orders.pay', $order) }}" method="POST" class="mt-5">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-5 py-3.5 text-sm font-extrabold text-white shadow-md hover:bg-emerald-700 hover:shadow-lg transition cursor-pointer">
                        <span>⚡ Simulasikan Bayar Berhasil</span>
                    </button>
                    <p class="mt-1 text-[11px] text-center text-emerald-700">Mengubah status menjadi LUNAS &amp; siap diproses</p>
                </form>

                <!-- Form Mock Fail -->
                <form action="{{ route('orders.mockFail', $order) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-2xl border border-orange-300 bg-orange-50 px-4 py-2.5 text-xs font-bold text-orange-700 hover:bg-orange-100 transition cursor-pointer">
                        <span>⚠️ Simulasikan Transaksi Ditolak</span>
                    </button>
                </form>

                <div class="mt-4 border-t border-slate-100 pt-4 space-y-2">
                    <!-- Cancel Order -->
                    @if($order->canBeCancelled())
                        <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini? Stok akan otomatis dikembalikan.')">
                            @csrf
                            <button type="submit" class="w-full rounded-xl border border-rose-200 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition cursor-pointer">
                                Batalkan Pesanan
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('orders.show', $order) }}" class="block text-center rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                        &larr; Lihat Detail Pesanan
                    </a>
                </div>
            </div>

            <!-- Security info badge -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-500 space-y-1.5">
                <div class="flex items-center gap-2 font-semibold text-slate-700">
                    <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Enkripsi Simulasi 256-Bit</span>
                </div>
                <p>Data transaksi diproses dalam lingkungan sandbox aman. Tidak ada tagihan riil yang didebit dari rekening atau e-wallet Anda.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function copyVaNumber() {
        const vaText = document.getElementById('va-number').innerText.trim();
        navigator.clipboard.writeText(vaText).then(() => {
            const btnText = document.getElementById('copy-text');
            const btnIcon = document.getElementById('copy-icon');
            btnText.innerText = 'Tersalin!';
            btnIcon.innerText = '✓';
            setTimeout(() => {
                btnText.innerText = 'Salin VA';
                btnIcon.innerText = '📋';
            }, 2500);
        }).catch(err => {
            alert('Nomor VA: ' + vaText);
        });
    }

    // Interactive countdown timer
    let totalSeconds = 24 * 3600 - 15;
    const timerEl = document.getElementById('countdown-timer');
    if (timerEl) {
        setInterval(() => {
            if (totalSeconds <= 0) return;
            totalSeconds--;
            const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
            const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
            const seconds = String(totalSeconds % 60).padStart(2, '0');
            timerEl.innerText = `${hours}:${minutes}:${seconds}`;
        }, 1000);
    }
</script>
@endsection
