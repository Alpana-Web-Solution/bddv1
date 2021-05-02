<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserCreateRequisitionTest extends TestCase
{
    // use DatabaseMigrations;
    use RefreshDatabase;

    public function test_create_a_user()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
        ->get('/dashboard')
        ->assertStatus(200);
        // ->assertSeeText('Welcome');
    }

    public function test_user_check_profile()
    {
        $this->actingAs(User::factory()->create());
        $this->get("/profile")
        ->assertSee(auth()->user()->name);
    }

    public function test_user_update_profile()
    {
        $this->actingAs(User::factory()->create());

        $this->post("/profile/update",[
            'name'=> auth()->user()->name,
            'mobile'=>auth()->user()->mobile,
            'address'=>'test address'
        ])
        ->assertStatus(302);
    }

}
