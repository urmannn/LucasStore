<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartAndCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_manage_cart_and_cannot_exceed_stock(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 100000, 'stock' => 3]);

        $this->actingAs($user)
            ->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 2])
            ->assertRedirect();

        $cartItem = CartItem::where('user_id', $user->id)->firstOrFail();
        $this->assertSame(2, $cartItem->quantity);

        $this->actingAs($user)
            ->post(route('cart.store'), ['product_id' => $product->id, 'quantity' => 2])
            ->assertSessionHas('error');

        $this->actingAs($user)
            ->patch(route('cart.update', $cartItem), ['quantity' => 3])
            ->assertSessionHas('success');

        $this->assertSame(3, $cartItem->fresh()->quantity);

        $otherUser = User::factory()->create();
        $this->actingAs($otherUser)
            ->delete(route('cart.destroy', $cartItem))
            ->assertForbidden();
    }

    public function test_checkout_creates_order_decrements_stock_and_clears_cart(): void
    {
        $user = User::factory()->create();
        $productA = Product::factory()->create(['price' => 150000, 'stock' => 10]);
        $productB = Product::factory()->create(['price' => 50000, 'stock' => 5]);

        CartItem::create(['user_id' => $user->id, 'product_id' => $productA->id, 'quantity' => 2]);
        CartItem::create(['user_id' => $user->id, 'product_id' => $productB->id, 'quantity' => 3]);

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'shipping_name' => 'Budi',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Mawar No. 12, Jakarta',
            'payment_method' => 'ewallet',
        ]);

        $order = Order::where('user_id', $user->id)->firstOrFail();
        $response->assertRedirect(route('orders.payment', $order));

        $this->assertSame(450000, $order->total_amount);
        $this->assertSame(Order::STATUS_PENDING, $order->status);
        $this->assertSame(8, $productA->fresh()->stock);
        $this->assertSame(2, $productB->fresh()->stock);
        $this->assertDatabaseCount('cart_items', 0);
        $this->assertDatabaseCount('order_items', 2);
    }

    public function test_checkout_cod_redirects_to_order_show(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 100000, 'stock' => 5]);
        CartItem::create(['user_id' => $user->id, 'product_id' => $product->id, 'quantity' => 1]);

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'shipping_name' => 'Budi',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Mawar No. 12, Jakarta',
            'payment_method' => 'cod',
        ]);

        $order = Order::where('user_id', $user->id)->firstOrFail();
        $response->assertRedirect(route('orders.show', $order));
    }

    public function test_checkout_fails_atomically_if_stock_is_insufficient(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 100000, 'stock' => 1]);

        CartItem::create(['user_id' => $user->id, 'product_id' => $product->id, 'quantity' => 2]);

        $this->actingAs($user)
            ->post(route('checkout.store'), [
                'shipping_name' => 'Budi',
                'shipping_phone' => '08123456789',
                'shipping_address' => 'Jl. Mawar No. 12',
                'payment_method' => 'bank_transfer',
            ])
            ->assertSessionHas('error');

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(1, $product->fresh()->stock);
    }

    public function test_owner_can_access_mock_payment_page_and_simulate_actions(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $product = Product::factory()->create(['price' => 200000, 'stock' => 5]);

        CartItem::create(['user_id' => $user->id, 'product_id' => $product->id, 'quantity' => 2]);

        $this->actingAs($user)->post(route('checkout.store'), [
            'shipping_name' => 'Budi',
            'shipping_phone' => '08123456789',
            'shipping_address' => 'Jl. Mawar No. 12',
            'payment_method' => 'ewallet',
        ]);

        $order = Order::firstOrFail();
        $this->assertSame(3, $product->fresh()->stock);

        // Security authorization check
        $this->actingAs($other)->get(route('orders.payment', $order))->assertForbidden();
        $this->actingAs($other)->post(route('orders.pay', $order))->assertForbidden();

        // Owner can view payment mock sandbox page
        $this->actingAs($user)
            ->get(route('orders.payment', $order))
            ->assertOk()
            ->assertSee('Payment Gateway Mock (Sandbox Mode)')
            ->assertSee('QRIS');

        // Test simulate failed payment
        $this->actingAs($user)
            ->post(route('orders.mockFail', $order))
            ->assertSessionHas('error');
        $this->assertSame(Order::STATUS_PENDING, $order->fresh()->status);

        // Test simulate successful payment
        $this->actingAs($user)
            ->post(route('orders.pay', $order))
            ->assertRedirect(route('orders.show', $order))
            ->assertSessionHas('success');

        $order->refresh();
        $this->assertSame(Order::STATUS_PAID, $order->status);
        $this->assertSame(Order::PAYMENT_PAID, $order->payment_status);

        // Paid order redirects away from payment page
        $this->actingAs($user)
            ->get(route('orders.payment', $order))
            ->assertRedirect(route('orders.show', $order));

        // Test cancellation restores stock
        $this->actingAs($user)->post(route('orders.cancel', $order))->assertSessionHas('success');
        $order->refresh();
        $this->assertSame(Order::STATUS_CANCELLED, $order->status);
        $this->assertSame(Order::PAYMENT_REFUNDED, $order->payment_status);
        $this->assertSame(5, $product->fresh()->stock);
    }
}
