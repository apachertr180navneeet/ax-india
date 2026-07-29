<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '9876543210',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'username' => 'johndoe',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['token', 'token_type', 'user'],
            ]);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_user_cannot_register_with_duplicate_email()
    {
        User::withoutEvents(fn () => User::factory()->create(['email' => 'john@example.com']));

        $response = $this->postJson('/api/v1/auth/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '9876543210',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'username' => 'johndoe',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_login_with_email()
    {
        $user = User::withoutEvents(fn () => User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('Password@123'),
        ]));

        // Manually create profile for the user
        $user->profile()->create(['username' => 'johndoe']);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'john@example.com',
            'password' => 'Password@123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['token', 'token_type', 'expires_in', 'user'],
            ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422);
    }

    public function test_authenticated_user_can_logout()
    {
        $user = User::withoutEvents(fn () => User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('Password@123'),
        ]));
        $user->profile()->create(['username' => 'johndoe']);

        $login = $this->postJson('/api/v1/auth/login', [
            'email' => 'john@example.com',
            'password' => 'Password@123',
        ]);

        $token = $login->json('data.token');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logged out successfully',
            ]);
    }

    public function test_user_can_change_password()
    {
        $user = User::withoutEvents(fn () => User::factory()->create([
            'password' => bcrypt('OldPass@123'),
        ]));
        $user->profile()->create(['username' => 'testuser']);

        $response = $this->actingAs($user)
            ->postJson('/api/v1/auth/change-password', [
                'current_password' => 'OldPass@123',
                'new_password' => 'NewPass@456',
                'new_password_confirmation' => 'NewPass@456',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Password changed successfully',
            ]);
    }

    public function test_user_cannot_change_password_with_wrong_current()
    {
        $user = User::withoutEvents(fn () => User::factory()->create([
            'password' => bcrypt('OldPass@123'),
        ]));
        $user->profile()->create(['username' => 'testuser']);

        $response = $this->actingAs($user)
            ->postJson('/api/v1/auth/change-password', [
                'current_password' => 'WrongPass@999',
                'new_password' => 'NewPass@456',
                'new_password_confirmation' => 'NewPass@456',
            ]);

        $response->assertStatus(422);
    }
}
