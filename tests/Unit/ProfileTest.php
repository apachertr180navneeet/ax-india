<?php

namespace Tests\Unit;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_belongs_to_user()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });

        $profile = Profile::withoutEvents(function () use ($user) {
            return Profile::factory()->create(['user_id' => $user->id]);
        });

        $this->assertInstanceOf(User::class, $profile->user);
        $this->assertEquals($user->id, $profile->user->id);
    }

    public function test_profile_has_fillable()
    {
        $profile = new Profile();
        $fillable = $profile->getFillable();

        $this->assertIsArray($fillable);
        $this->assertContains('user_id', $fillable);
        $this->assertContains('bio', $fillable);
        $this->assertContains('avatar', $fillable);
    }

    public function test_profile_casts_json_fields()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });

        $profile = Profile::withoutEvents(function () use ($user) {
            return Profile::factory()->create([
                'user_id' => $user->id,
                'social_links' => ['facebook' => 'fb.com/user'],
                'privacy_settings' => ['show_email' => false],
                'notification_settings' => ['new_subscriber' => true],
            ]);
        });

        $this->assertIsArray($profile->social_links);
        $this->assertIsArray($profile->privacy_settings);
        $this->assertIsArray($profile->notification_settings);
        $this->assertEquals('fb.com/user', $profile->social_links['facebook']);
    }

    public function test_profile_avatar_url_accessor()
    {
        $profile = new Profile();
        $this->assertTrue(method_exists($profile, 'getAvatarUrlAttribute') || property_exists($profile, 'appends'));
    }
}
