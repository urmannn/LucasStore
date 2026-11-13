<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_as_customer_even_if_role_field_is_tampered(): void
    {
        $response = $this->post('/register', [
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Asia Afrika No. 1',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $user = User::where('email', 'siti@example.com')->firstOrFail();
        $this->assertSame(User::ROLE_CUSTOMER, $user->role);
    }

    public function test_user_can_login_and_update_profile(): void
    {
        $user = User::factory()->create([
            'password' => 'secret123',
            'role' => User::ROLE_CUSTOMER,
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ])->assertRedirect(route('home'));

        $this->put(route('profile.update'), [
            'name' => 'Nama Baru',
            'phone' => '0899999999',
            'address' => 'Alamat Baru',
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
            'phone' => '0899999999',
            'address' => 'Alamat Baru',
        ]);
    }

    public function test_admin_middleware_blocks_customers_and_allows_admins(): void
    {
        $customer = User::factory()->create(['role' => User::ROLE_CUSTOMER]);
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($customer)
            ->get(route('admin.dashboard'))
            ->assertForbidden();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }
}
