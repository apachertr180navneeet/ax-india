<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();
        $user->profile()->create([
            'username' => 'olduser',
            'bio' => 'Old bio',
        ]);

        $response = $this->actingAs($user)
            ->putJson('/api/v1/profile', [
                'username' => 'newuser',
                'bio' => 'Updated bio',
                'country' => 'India',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Profile updated successfully',
            ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'bio' => 'Updated bio',
        ]);
    }

    public function test_user_can_upload_avatar()
    {
        $user = User::factory()->create();
        $user->profile()->create(['username' => 'testuser']);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)
            ->postJson('/api/v1/profile/avatar', [
                'avatar' => $file,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Avatar updated successfully',
            ]);
    }

    public function test_user_can_update_privacy_settings()
    {
        $user = User::factory()->create();
        $user->profile()->create(['username' => 'testuser']);

        $response = $this->actingAs($user)
            ->putJson('/api/v1/profile/privacy-settings', [
                'settings' => ['show_email' => false, 'show_subscribers' => true],
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Privacy settings updated successfully',
            ]);
    }

    public function test_user_can_update_notification_settings()
    {
        $user = User::factory()->create();
        $user->profile()->create(['username' => 'testuser']);

        $response = $this->actingAs($user)
            ->putJson('/api/v1/profile/notification-settings', [
                'settings' => ['new_subscriber' => true, 'new_comment' => false],
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Notification settings updated successfully',
            ]);
    }
}
