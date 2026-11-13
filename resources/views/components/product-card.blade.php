@props(['product'])

<article class="group flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xs transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-emerald-300">
    <!-- Product Image with Badge -->
    <a href="{{ route('products.show', $product) }}" class="relative aspect-[4/3] overflow-hidden bg-slate-100 block">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">

        @if($product->stock < 1)
            <span class="absolute top-3 left-3 rounded-full bg-slate-900/85 backdrop-blur-xs px-3 py-1 text-xs font-bold text-white shadow-xs">
                Stok Habis
            </span>
        @elseif($product->stock <= 5)
            <span class="absolute top-3 left-3 rounded-full bg-orange-500 px-3 py-1 text-xs font-extrabold text-white shadow-xs animate-bounce">
                Sisa {{ $product->stock }}!
            </span>
        @endif

        <span class="absolute bottom-3 right-3 rounded-full bg-white/90 backdrop-blur-xs px-2.5 py-0.5 text-[11px] font-bold text-emerald-800 shadow-2xs">
            {{ $product->category?->name ?? 'Produk' }}
        </span>
    </a>

    <!-- Product Info -->
    <div class="flex flex-1 flex-col p-4 sm:p-5">
        <a href="{{ route('products.show', $product) }}" class="line-clamp-2 text-base font-bold text-slate-900 group-hover:text-emerald-700 transition">
            {{ $product->name }}
        </a>

        <div class="mt-2.5 flex items-baseline justify-between gap-2">
            <div>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Harga</span>
                <p class="text-xl font-black text-orange-600">{{ $product->formatted_price }}</p>
            </div>
            <span class="text-xs font-semibold text-slate-500">Stok: {{ $product->stock }}</span>
        </div>

        <!-- Action Buttons -->
        <div class="mt-auto pt-4 flex items-center gap-2">
            <a href="{{ route('products.show', $product) }}" class="flex-1 rounded-xl border border-slate-200 px-3 py-2 text-center text-xs font-bold text-slate-700 hover:border-emerald-500 hover:text-emerald-700 hover:bg-emerald-50/50 transition">
                Detail
            </a>
            @auth
                <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" @disabled($product->stock < 1) class="w-full rounded-xl bg-emerald-600 px-3 py-2 text-xs font-extrabold text-white hover:bg-emerald-700 disabled:cursor-not-allowed disabled:bg-slate-300 transition cursor-pointer shadow-2xs">
                        + Beli
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="flex-1 rounded-xl bg-orange-500 px-3 py-2 text-center text-xs font-extrabold text-white hover:bg-orange-600 transition shadow-2xs">
                    + Beli
                </a>
            @endauth
        </div>
    </div>
</article>
