@extends('layouts.admin')

@section('title', 'Kelola Kategori — Admin NusaStore')
@section('header', 'Kelola Kategori Produk')

@section('content')
<div class="flex items-center justify-between">
    <p class="text-xs font-semibold text-slate-500">Kelompokkan produk agar mudah ditemukan oleh calon pembeli.</p>
    <a href="{{ route('admin.categories.create') }}" class="rounded-2xl bg-orange-500 px-4 py-2 text-xs font-extrabold text-white hover:bg-orange-600 transition shadow-xs">
        + Tambah Kategori
    </a>
</div>

<div class="mt-5 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xs">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
            <tr>
                <th class="px-5 py-3.5">Nama Kategori</th>
                <th class="px-5 py-3.5">Slug URL</th>
                <th class="px-5 py-3.5">Total Produk</th>
                <th class="px-5 py-3.5 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($categories as $category)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-5 py-3.5 font-bold text-slate-900">{{ $category->name }}</td>
                    <td class="px-5 py-3.5 font-mono text-xs text-slate-500">{{ $category->slug }}</td>
                    <td class="px-5 py-3.5 font-semibold text-slate-700">{{ $category->products_count }} item</td>
                    <td class="px-5 py-3.5 text-right space-x-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-800 cursor-pointer">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-5 py-8 text-center text-slate-400 text-xs">Belum ada kategori terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $categories->links() }}</div>
@endsection
