@extends('layouts.admin')

@section('title', 'Tambah Produk — Admin NusaStore')
@section('header', 'Tambah Produk Baru')

@section('content')
<div class="max-w-2xl rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form', ['submitLabel' => 'Simpan Produk'])
    </form>
</div>
@endsection
