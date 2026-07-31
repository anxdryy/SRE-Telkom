<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'correct-password',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'correct-password',
        ]);

        $response->assertRedirect(route('departments.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'correct-password',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_guest_is_redirected_from_admin_routes(): void
    {
        $response = $this->get('/admin/departments');

        $response->assertRedirect(route('auth.showLogin'));
    }

    public function test_authenticated_admin_is_redirected_away_from_login_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertRedirect(route('departments.index'));
    }

    public function test_login_is_rate_limited_after_five_attempts(): void
    {
        User::factory()->create(['email' => 'admin@example.com', 'password' => 'correct-password']);

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'admin@example.com', 'password' => 'wrong']);
        }

        $response = $this->post('/login', ['email' => 'admin@example.com', 'password' => 'wrong']);

        $response->assertStatus(429);
    }

    public function test_logout_clears_authentication(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    }
}
