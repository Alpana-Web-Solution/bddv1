<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AdminLoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    
    public function test_admin_login()
    {
        $user = User::factory(['is_admin'=>1])->create();

        $this->actingAs($user)
        ->get('/admin/dashboard')
        ->assertSeeText('Welcome');
        // $response = $this->actingAs(User::factory(['is_admin'=>1])->create())
                            // ->visit('admin/dashboard')
                            // ->see('Welcome');


        // $response->assertStatus(200);
    }
}
