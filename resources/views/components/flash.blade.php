@if (session('success'))
    <div class="mb-5 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/90 px-4 py-3.5 text-xs font-bold text-emerald-900 shadow-2xs">
        <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-white font-black text-xs">✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="mb-5 flex items-center gap-3 rounded-2xl border border-orange-200 bg-orange-50/90 px-4 py-3.5 text-xs font-bold text-orange-950 shadow-2xs">
        <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-orange-500 text-white font-black text-xs">!</span>
        <span>{{ session('error') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-xs text-rose-900 shadow-2xs">
        <p class="font-extrabold mb-1">Periksa kembali data Anda:</p>
        <ul class="list-disc list-inside space-y-0.5 font-semibold">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
