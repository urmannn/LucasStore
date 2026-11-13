<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Nama Produk</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
        </div>
        <div>
            <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Kategori</label>
            <select name="category_id" id="category_id" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none cursor-pointer">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id ?? '') === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="price" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Harga (Rupiah)</label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price ?? '') }}" min="100" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
        </div>
        <div>
            <label for="stock" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Stok Barang</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
        </div>
    </div>

    <div>
        <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Deskripsi Produk</label>
        <textarea name="description" id="description" rows="4" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none leading-relaxed">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div>
        <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Foto Produk Real (JPG/PNG/WEBP, maks 2MB)</label>
        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-xs text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-xs file:font-bold file:text-emerald-800 hover:file:bg-emerald-100 cursor-pointer">
        @isset($product)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mt-3 h-24 w-32 rounded-2xl border border-slate-200 object-cover shadow-2xs">
        @endisset
    </div>

    <label class="flex items-center gap-2 text-xs font-bold text-slate-700">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true)) class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
        Tampilkan produk di katalog belanja (Status Aktif)
    </label>

    <div class="flex items-center gap-3 pt-3">
        <button type="submit" class="rounded-2xl bg-emerald-600 px-6 py-2.5 text-xs font-extrabold text-white hover:bg-emerald-700 transition cursor-pointer shadow-xs">
            {{ $submitLabel }}
        </button>
        <a href="{{ route('admin.products.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50">
            Batal
        </a>
    </div>
</div>
