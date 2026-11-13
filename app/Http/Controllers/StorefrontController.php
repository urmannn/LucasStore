<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    private const SORT_MAP = [
        'latest' => ['created_at', 'desc'],
        'price_asc' => ['price', 'asc'],
        'price_desc' => ['price', 'desc'],
        'name_asc' => ['name', 'asc'],
    ];

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $categorySlug = trim((string) $request->query('category', ''));
        $sortKey = (string) $request->query('sort', 'latest');
        [$sortColumn, $sortDir] = self::SORT_MAP[$sortKey] ?? self::SORT_MAP['latest'];

        $categories = Category::query()
            ->withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->active()
            ->with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($categorySlug !== '', function ($query) use ($categorySlug) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
            })
            ->orderBy($sortColumn, $sortDir)
            ->paginate(12)
            ->withQueryString();

        return view('store.index', [
            'categories' => $categories,
            'products' => $products,
            'search' => $search,
            'activeCategory' => $categorySlug,
            'sortKey' => array_key_exists($sortKey, self::SORT_MAP) ? $sortKey : 'latest',
        ]);
    }

    public function show(Request $request, Product $product): View
    {
        if (! $product->is_active && ! $request->user()?->isAdmin()) {
            abort(404);
        }

        $product->load('category');

        $relatedProducts = Product::query()
            ->active()
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->latest()
            ->take(4)
            ->get();

        return view('store.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
