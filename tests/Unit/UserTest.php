<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\EmailVerification;
use App\User;

class UserTest extends TestCase
{
    use WithFaker;

    public function testStore()
    {
        $user = $this->createUser();

        $userResource = (new UserResource($user))->resolve();

        $data = $this->getUserData();

        $response = $this->json('POST', route('api.register'), $data);

        $response->assertJsonMissingValidationErrors();

        $response->assertStatus(201);

        $this->assertEmpty(array_diff_key($userResource, $response->json()['data']));
    }

    public function testLogin()
    {
        $password = 'password';

        $user = factory(User::class)->create([
            'password' => Hash::make($password),
            'email_verified_at' => now()
        ]);

        $data = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->json('POST', route('api.login'), $data);

        $response->assertJsonMissingValidationErrors();

        $response->assertStatus(200);
    }

    public function createUser()
    {
        $user = factory(User::class)->create();
                
        EmailVerification::create([
            'email' => $user->email,
            'token' => str_random(32),
            'expire' => date('Y-m-d H:i:s', strtotime('+1 day', time()))
        ]);

        return $user;
    }

    private function getUserData()
    {
        $password = str_random(10);

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            "password" => $password,
            "password_confirmation" => $password,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber
        ];

        return $data;
    }
}