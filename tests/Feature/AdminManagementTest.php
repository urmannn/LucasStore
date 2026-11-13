<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_crud_categories_and_cannot_delete_non_empty_category(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Gadget Baru',
                'description' => 'Deskripsi',
            ])
            ->assertRedirect(route('admin.categories.index'));

        $category = Category::where('slug', 'gadget-baru')->firstOrFail();

        $this->actingAs($admin)
            ->put(route('admin.categories.update', $category), [
                'name' => 'Gadget Updated',
                'description' => 'Updated',
            ])
            ->assertRedirect(route('admin.categories.index'));

        $category->refresh();
        $this->assertSame('Gadget Updated', $category->name);

        Product::factory()->create(['category_id' => $category->id]);

        $this->actingAs($admin)
            ->delete(route('admin.categories.destroy', $category))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_admin_can_crud_products_with_image_upload(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $category = Category::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Kamera Mirrorless',
                'description' => 'Kamera 4K',
                'price' => 5500000,
                'stock' => 7,
                'is_active' => '1',
                'image' => UploadedFile::fake()->image('camera.jpg'),
            ])
            ->assertRedirect(route('admin.products.index'));

        $product = Product::where('name', 'Kamera Mirrorless')->firstOrFail();
        $this->assertNotNull($product->image);
        Storage::disk('public')->assertExists($product->image);

        $oldImage = $product->image;

        $this->actingAs($admin)
            ->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        Storage::disk('public')->assertMissing($oldImage);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_admin_updating_order_to_cancelled_restores_stock(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $customer = User::factory()->create(['role' => User::ROLE_CUSTOMER]);
        $product = Product::factory()->create(['price' => 100000, 'stock' => 4]);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-TEST-001',
            'total_amount' => 200000,
            'status' => Order::STATUS_PROCESSING,
            'payment_method' => 'bank_transfer',
            'payment_status' => Order::PAYMENT_PAID,
            'shipping_name' => 'Customer',
            'shipping_phone' => '08123',
            'shipping_address' => 'Jakarta',
            'paid_at' => now(),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => 100000,
            'quantity' => 2,
            'subtotal' => 200000,
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.orders.update', $order), [
                'status' => Order::STATUS_CANCELLED,
            ])
            ->assertSessionHas('success');

        $this->assertSame(6, $product->fresh()->stock);
        $this->assertSame(Order::PAYMENT_REFUNDED, $order->fresh()->payment_status);
    }
}
