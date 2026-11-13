@extends('layouts.admin')

@section('title', 'Edit Produk — Admin NusaStore')
@section('header', 'Edit Produk')

@section('content')
<div class="max-w-2xl rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.products._form', ['product' => $product, 'submitLabel' => 'Perbarui Produk'])
    </form>
</div>
@endsection
