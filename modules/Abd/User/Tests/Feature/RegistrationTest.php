<?php

namespace Abd\User\Tests\Feature;

use Abd\RolePermissions\Database\Seeders\RolePermissionTableSeeder;
use Abd\User\Models\User;
use Abd\User\Services\VerifyCodeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_see_register_form()
    {
        $response = $this->get(route('loginForm'));

        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $response = $this->registerNewUser();

        $response->assertRedirect(route('home'));

        $this->assertCount(1, User::all());
    }

    public function test_user_have_to_verify_account()
    {
        $this->registerNewUser();
        $response = $this->get(route('home'));

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_user_can_verify_account()
    {
        $user = User::create([
            'name' => 'hossein',
            'email' => 'test@test.test',
            'password' => bcrypt('aA!123')
        ]);

        $code = VerifyCodeService::generate();
        VerifyCodeService::store($user->id, $code, now()->addDay());
        auth()->loginUsingId($user->id);
        $this->assertAuthenticated();

        $this->post(route('verification.verify'), [
            'verify_code' => $code
        ]);
        $this->assertEquals(true, $user->fresh()->hasVerifiedEmail());
    }

    public function test_verified_user_can_see_home_page()
    {
        $this->seed(RolePermissionTableSeeder::class);

        $this->registerNewUser();

        $this->assertAuthenticated();

        auth()->user()->markEmailAsVerified();

        $response = $this->get(route('home'));

        $response->assertOk();
    }

    private function registerNewUser()
    {
        return $this->post(route('register'), [
            'name' => 'hossein',
            'email' => 'hossein@test.test',
            'mobile' => '9123456789',
            'password' => 'aA!123',
            'password_confirmation' => 'aA!123'
        ]);
    }
}
