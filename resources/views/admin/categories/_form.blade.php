<div class="space-y-4">
    <div>
        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Nama Kategori</label>
        <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none">
    </div>
    <div>
        <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Deskripsi Singkat (Opsional)</label>
        <textarea name="description" id="description" rows="3" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 focus:outline-none leading-relaxed">{{ old('description', $category->description ?? '') }}</textarea>
    </div>
    <div class="flex items-center gap-3 pt-3">
        <button type="submit" class="rounded-2xl bg-emerald-600 px-6 py-2.5 text-xs font-extrabold text-white hover:bg-emerald-700 transition cursor-pointer shadow-xs">
            {{ $submitLabel }}
        </button>
        <a href="{{ route('admin.categories.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50">
            Batal
        </a>
    </div>
</div>
