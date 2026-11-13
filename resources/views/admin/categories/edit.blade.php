@extends('layouts.admin')

@section('title', 'Edit Kategori — Admin NusaStore')
@section('header', 'Edit Kategori Produk')

@section('content')
<div class="max-w-xl rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.categories._form', ['category' => $category, 'submitLabel' => 'Perbarui Kategori'])
    </form>
</div>
@endsection
