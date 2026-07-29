<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'AX India',
            'full_name' => 'Admin AX India',
            'slug' => 'admin-ax-india',
            'email' => 'admin@axindia.com',
            'phone' => '8000000001',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'status' => 'active',
            'country' => 'India',
            'device_type' => 'ios',
        ]);
        $admin->assignRole('admin');

        Profile::create([
            'user_id' => $admin->id,
            'username' => 'admin_axindia',
            'bio' => 'AX India administrator',
            'gender' => 'male',
            'country' => 'India',
        ]);

        $moderator = User::create([
            'first_name' => 'Moderator',
            'last_name' => 'AX India',
            'full_name' => 'Moderator AX India',
            'slug' => 'moderator-ax-india',
            'email' => 'mod@axindia.com',
            'phone' => '8000000002',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role' => 'user',
            'status' => 'active',
            'country' => 'India',
            'device_type' => 'ios',
        ]);
        $moderator->assignRole('moderator');

        Profile::create([
            'user_id' => $moderator->id,
            'username' => 'mod_axindia',
            'bio' => 'AX India moderator',
            'gender' => 'male',
            'country' => 'India',
        ]);

        for ($i = 1; $i <= 10; $i++) {
            $firstName = fake()->firstName();
            $lastName = fake()->lastName();
            $fullName = $firstName . ' ' . $lastName;

            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'full_name' => $fullName,
                'slug' => Str::slug($fullName . '-' . uniqid()),
                'email' => "user{$i}@axindia.com",
                'phone' => '80000000' . str_pad((string)($i + 2), 2, '0', STR_PAD_LEFT),
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => 'user',
                'status' => 'active',
                'address' => fake()->address(),
                'area' => fake()->streetAddress(),
                'city' => fake()->city(),
                'state' => fake()->state(),
                'country' => 'India',
                'device_type' => 'ios',
            ]);
            $user->assignRole('user');

            Profile::create([
                'user_id' => $user->id,
                'username' => fake()->unique()->userName() . $i,
                'bio' => fake()->text(200),
                'gender' => fake()->randomElement(['male', 'female', 'other']),
                'dob' => fake()->dateTimeBetween('1970-01-01', '2006-12-31')->format('Y-m-d'),
                'country' => 'India',
                'state' => fake()->state(),
                'city' => fake()->city(),
                'website' => fake()->url(),
            ]);
        }
    }
}
