@extends('layouts.admin')

@section('title', 'Kelola Pesanan — Admin NusaStore')
@section('header', 'Kelola Pesanan Pelanggan')

@section('content')
<form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
    <input type="text" name="q" value="{{ $search }}" placeholder="No. pesanan / nama pembeli..." class="rounded-2xl border border-slate-300 bg-white px-4 py-2 text-xs font-semibold focus:border-emerald-500 focus:outline-none">
    <select name="status" onchange="this.form.submit()" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold cursor-pointer">
        <option value="">Semua Status Pesanan</option>
        @foreach($statuses as $key => $meta)
            <option value="{{ $key }}" @selected($status === $key)>{{ $meta['label'] }}</option>
        @endforeach
    </select>
    <button type="submit" class="rounded-2xl bg-emerald-700 px-4 py-2 text-xs font-bold text-white hover:bg-emerald-800 cursor-pointer shadow-xs">Filter</button>
</form>

<div class="mt-5 overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-xs">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
            <tr>
                <th class="px-5 py-3.5">No. Pesanan</th>
                <th class="px-5 py-3.5">Pelanggan</th>
                <th class="px-5 py-3.5">Total Tagihan</th>
                <th class="px-5 py-3.5">Status Pesanan</th>
                <th class="px-5 py-3.5">Pembayaran</th>
                <th class="px-5 py-3.5 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($orders as $order)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-5 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $order->order_number }}</td>
                    <td class="px-5 py-3.5">
                        <p class="font-bold text-slate-900">{{ $order->shipping_name }}</p>
                        <p class="text-[11px] text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </td>
                    <td class="px-5 py-3.5 font-black text-slate-900 text-sm">{{ $order->formatted_total }}</td>
                    <td class="px-5 py-3.5">
                        <span class="rounded-full border px-2.5 py-0.5 text-xs font-bold {{ $order->status_badge }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="rounded-full border px-2.5 py-0.5 text-xs font-bold {{ $order->payment_status_badge }}">
                            {{ $order->payment_status_label }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="rounded-xl border border-slate-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-800 hover:bg-emerald-100 transition">
                            Kelola &rarr;
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-slate-400 text-xs">Belum ada pesanan masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $orders->links() }}</div>
@endsection
