<?php

namespace App\Services;

use App\Models\User;
use App\Models\Profile;
use App\Traits\Sluggable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthService
{
    use Sluggable;

    public function __construct(private User $user, private Profile $profile) {}

    public function register(array $data): User
    {
        try {
            return DB::transaction(function () use ($data) {
                $user = $this->user->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'phone' => $data['phone'] ?? null,
                ]);

                $this->profile->create([
                    'user_id' => $user->id,
                    'username' => $data['username'] ?? $this->generateSlug($this->user, $data['name']),
                    'gender' => $data['gender'] ?? null,
                    'dob' => $data['dob'] ?? null,
                    'country' => $data['country'] ?? null,
                    'state' => $data['state'] ?? null,
                    'city' => $data['city'] ?? null,
                ]);

                Log::info('User registered successfully', ['user_id' => $user->id, 'email' => $user->email]);

                return $user;
            });
        } catch (\Exception $e) {
            Log::error('User registration failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function login(array $credentials, bool $remember = false): array
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                throw ValidationException::withMessages(['email' => 'Invalid credentials']);
            }

            $user = auth()->user();

            $this->checkAccountStatus($user);

            if ($remember) {
                JWTAuth::setTTL(43200);
            }

            Log::info('User logged in', ['user_id' => $user->id]);

            return [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
                'user' => $user->load('profile'),
            ];
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Login failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function logout(): void
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            Log::info('User logged out', ['user_id' => auth()->id()]);
        } catch (JWTException $e) {
            Log::error('Logout failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function sendEmailVerification($user): void
    {
        $user->sendEmailVerificationNotification();
    }

    public function verifyEmail($id, $hash): bool
    {
        $user = $this->user->findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            throw ValidationException::withMessages(['email' => 'Invalid verification hash']);
        }

        if ($user->hasVerifiedEmail()) {
            return true;
        }

        $user->markEmailAsVerified();
        Log::info('Email verified', ['user_id' => $user->id]);

        return true;
    }

    public function sendPasswordResetLink(string $email): string
    {
        $status = Password::sendResetLink(['email' => $email]);

        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages(['email' => __($status)]);
        }

        Log::info('Password reset link sent', ['email' => $email]);

        return __($status);
    }

    public function resetPassword(array $data): string
    {
        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages(['email' => __($status)]);
        }

        Log::info('Password reset successful');

        return __($status);
    }

    public function changePassword($user, string $currentPassword, string $newPassword): bool
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        Log::info('Password changed', ['user_id' => $user->id]);

        return true;
    }

    public function checkAccountStatus($user): void
    {
        if ($user->deleted_at !== null) {
            throw ValidationException::withMessages(['account' => 'Account has been deactivated']);
        }
    }
}
