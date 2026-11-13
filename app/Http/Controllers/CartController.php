<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cartItems = CartItem::query()
            ->with('product.category')
            ->where('user_id', $request->user()->id)
            ->orderBy('id')
            ->get();

        $total = $cartItems->sum(fn (CartItem $item) => $item->subtotal);

        return view('cart.index', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $requestedQty = (int) ($validated['quantity'] ?? 1);

        if (! $product->is_active || $product->stock < 1) {
            return back()->with('error', 'Produk ini sedang tidak tersedia atau stok habis.');
        }

        $existing = CartItem::query()
            ->where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->first();

        $newQty = ($existing?->quantity ?? 0) + $requestedQty;

        if ($newQty > $product->stock) {
            return back()->with('error', "Jumlah melebihi stok tersedia ({$product->stock} unit).");
        }

        CartItem::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $product->id],
            ['quantity' => $newQty]
        );

        return back()->with('success', "\"{$product->name}\" ditambahkan ke keranjang.");
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->authorizeOwner($request, $cartItem);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $product = $cartItem->product;

        if (! $product || ! $product->is_active) {
            $cartItem->delete();

            return back()->with('error', 'Produk tidak lagi tersedia dan telah dihapus dari keranjang.');
        }

        if ($validated['quantity'] > $product->stock) {
            return back()->with('error', "Stok tersedia hanya {$product->stock} unit.");
        }

        $cartItem->update(['quantity' => $validated['quantity']]);

        return back()->with('success', 'Jumlah keranjang diperbarui.');
    }

    public function destroy(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->authorizeOwner($request, $cartItem);

        $cartItem->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    private function authorizeOwner(Request $request, CartItem $cartItem): void
    {
        if ($cartItem->user_id !== $request->user()->id) {
            abort(403);
        }
    }
}
