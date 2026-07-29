<?php

namespace Tests\Unit;

use App\Models\Profile;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_profile_relationship()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });

        Profile::withoutEvents(function () use ($user) {
            Profile::factory()->create(['user_id' => $user->id]);
        });

        $this->assertInstanceOf(Profile::class, $user->fresh()->profile);
    }

    public function test_user_has_videos_relationship()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $video = Video::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->videos->contains($video));
        $this->assertEquals(1, $user->videos->count());
    }

    public function test_user_has_subscriptions_relationship()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $creator = User::withoutEvents(function () {
            return User::factory()->create();
        });

        $subscription = Subscription::factory()->create([
            'subscriber_id' => $user->id,
            'creator_id' => $creator->id,
        ]);

        $this->assertTrue($user->subscriptions->contains($subscription));
    }

    public function test_user_can_have_roles()
    {
        $user = new User();
        $this->assertTrue(method_exists($user, 'roles'));
    }

    public function test_user_has_fillable_attributes()
    {
        $user = new User();
        $this->assertIsArray($user->getFillable());
    }

    public function test_user_hidden_attributes()
    {
        $user = new User();
        $hidden = $user->getHidden();
        $this->assertContains('password', $hidden);
        $this->assertContains('remember_token', $hidden);
    }
}
