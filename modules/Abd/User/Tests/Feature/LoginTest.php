<?php

namespace Abd\User\Tests\Feature;

use Abd\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login_by_email()
    {
        $user = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => bcrypt('aA!123')
        ]);

        $this->post(route('login', [
            'email' => $user->email,
            'password' => 'aA!123'
        ]));

        $this->assertAuthenticated();
    }

    public function test_user_can_login_by_mobile()
    {
        $user = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'mobile' => '9123456789',
            'password' => bcrypt('aA!123')
        ]);

        $this->post(route('login', [
            'email' => $user->mobile,
            'password' => 'aA!123'
        ]));

        $this->assertAuthenticated();
    }
}
