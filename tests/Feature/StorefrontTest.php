<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    public function test_storefront_shows_only_active_products_and_supports_search_and_filter(): void
    {
        $electronics = Category::factory()->create(['name' => 'Elektronik', 'slug' => 'elektronik']);
        $fashion = Category::factory()->create(['name' => 'Fashion', 'slug' => 'fashion']);

        $activeKeyboard = Product::factory()->create([
            'category_id' => $electronics->id,
            'name' => 'Keyboard Wireless',
            'is_active' => true,
        ]);

        Product::factory()->create([
            'category_id' => $fashion->id,
            'name' => 'Jaket Kanvas',
            'is_active' => true,
        ]);

        Product::factory()->create([
            'category_id' => $electronics->id,
            'name' => 'Produk Nonaktif',
            'is_active' => false,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Keyboard Wireless')
            ->assertSee('Jaket Kanvas')
            ->assertDontSee('Produk Nonaktif');

        $this->get('/?category=elektronik')
            ->assertOk()
            ->assertSee('Keyboard Wireless')
            ->assertDontSee('Jaket Kanvas');

        $this->get('/?q=Jaket')
            ->assertOk()
            ->assertSee('Jaket Kanvas')
            ->assertDontSee('Keyboard Wireless');

        $this->get(route('products.show', $activeKeyboard))
            ->assertOk()
            ->assertSee('Keyboard Wireless');
    }

    public function test_inactive_product_returns_not_found_for_guests(): void
    {
        $inactive = Product::factory()->create(['is_active' => false]);

        $this->get(route('products.show', $inactive))
            ->assertNotFound();
    }
}
