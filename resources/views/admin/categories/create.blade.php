@extends('layouts.admin')

@section('title', 'Tambah Kategori — Admin NusaStore')
@section('header', 'Tambah Kategori Produk')

@section('content')
<div class="max-w-xl rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        @include('admin.categories._form', ['submitLabel' => 'Simpan Kategori'])
    </form>
</div>
@endsection
