<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserManagerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_usermanager_non_register_user_index()
    {

        $response = $this->get('/admin/usermanager');

        $response->assertStatus(403);
    }


    public function test_usermanager_register_user_index()
    {
        $this->actingAs(User::factory()->create());
        $this->assertAuthenticated('web');

        $response = $this->get('/admin/usermanager');

        $response->assertStatus(403);
    }

    public function test_usermanager_create_user()
    {
        $user = [
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
        ];

        $this->actingAs(User::factory(['is_admin'=>1])->create());
        $this->assertAuthenticated('web');

        $response = $this->get('/admin/usermanager/create');
        $response->assertStatus(200);

        $postResponse = $this->post('/admin/usermanager', $user);

        $postResponse->assertStatus(302);
    }
}
