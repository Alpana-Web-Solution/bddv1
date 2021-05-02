<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserRegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_registration_form_show()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_user_registration()
    {
        // $this->actingAs(User::factory(['is_admin'=>1])->create());
        $response = $this->withHeaders(['accept'=>'application/json'])->post('/register', [
            'name' => "User",
            'username'=>'user123123',
            'mobile'=>rand(1000000000,9999999999),
            'blood_group'=> rand(1,8),
            'pincode'=>742149,
            // 'is_admin'=>1,
            'email' => 'user1@user.local',
            'email_verified_at' => now(),
            'password' => 'password',
            'password_confirmation'=>'password',
            'blood_donor'=>1,
            'last_donated'=>now()
        ]);
        // $response->dump();
        // $this->assertAuthenticated();
        $this->assertAuthenticated('web');
        $response
        ->assertStatus(201);
        // ->assertHeader('Redirect', url('/dashboard'));
        // $response->assertRedirect('/dashboard');
    }
}
