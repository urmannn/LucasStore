@extends('layouts.admin')

@section('title', 'Kelola Produk — Admin NusaStore')
@section('header', 'Kelola Katalog Produk')

@section('content')
<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama produk..." class="rounded-2xl border border-slate-300 bg-white px-4 py-2 text-xs font-semibold focus:border-emerald-500 focus:outline-none">
        <select name="category_id" onchange="this.form.submit()" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold cursor-pointer">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-2xl bg-emerald-700 px-4 py-2 text-xs font-bold text-white hover:bg-emerald-800 cursor-pointer">Filter</button>
    </form>

    <a href="{{ route('admin.products.create') }}" class="rounded-2xl bg-orange-500 px-4 py-2 text-center text-xs font-extrabold text-white hover:bg-orange-600 transition shadow-xs">
        + Tambah Produk Baru
    </a>
</div>

<div class="mt-5 overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-xs">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
            <tr>
                <th class="px-5 py-3.5">Produk</th>
                <th class="px-5 py-3.5">Kategori</th>
                <th class="px-5 py-3.5">Harga</th>
                <th class="px-5 py-3.5">Stok</th>
                <th class="px-5 py-3.5">Status</th>
                <th class="px-5 py-3.5 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($products as $product)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-11 w-14 rounded-xl object-cover bg-slate-100 border border-slate-200">
                            <div>
                                <p class="font-bold text-slate-900">{{ $product->name }}</p>
                                <p class="font-mono text-[11px] text-slate-400">{{ $product->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-xs font-semibold text-slate-600">{{ $product->category?->name }}</td>
                    <td class="px-5 py-3.5 font-black text-slate-900 text-sm">{{ $product->formatted_price }}</td>
                    <td class="px-5 py-3.5">
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ $product->stock <= 5 ? 'bg-orange-100 text-orange-800' : 'bg-slate-100 text-slate-700' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ $product->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800 cursor-pointer">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-slate-400 text-xs">Belum ada data produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $products->links() }}</div>
@endsection
