<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class BrokenLinkTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    
    public function test_admin_check_login()
    {
       
        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/dashboard')
        ->assertSeeText('Welcome');
    }

    public function test_admin_check_usermanager()
    {

        $user = User::factory(['is_admin'=>1])->create();
        
        $this->actingAs($user)
        ->get('/admin/usermanager')
        ->assertSeeText('name',$user->name);
    }

    public function test_admin_check_requisition()
    {
            
        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/requisition')
        ->assertStatus(200);
    }

    public function test_admin_check_donation()
    {
            
        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/donation')
        ->assertStatus(200);
    }

    public function test_admin_check_donor()
    {
        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/donor')
        ->assertStatus(200);
    }

    public function test_admin_check_settings()
    {

        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/settings')
        ->assertStatus(200);
    }

    public function test_admin_check_certificate()
    {
        
        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/certificate')
        ->assertStatus(200);
    }

    public function tset_admin_check_pincode()
    {
        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/pincode')
        ->assertStatus(200);
    }

    public function test_admin_check_language_english()
    {
        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/requisition?change_language=en')
        ->assertSeeText('Create');
    }

    public function test_admin_check_language_bengali()
    {
        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/requisition?change_language=bn')
        ->assertSeeText('সৃষ্টি');
    }

    public function test_admin_check_home_page_edit_form()
    {
        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/page/home/edit')
        ->assertStatus(200);
    }

    public function test_admin_check_about_page_edit_form()
    {
        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/page/about/edit')
        ->assertStatus(200);
    }

    public function test_admin_check_contact_page_edit_form()
    {
        $this->actingAs(User::factory(['is_admin'=>1])->create())
        ->get('/admin/page/contact/edit')
        ->assertStatus(200);
    }
    
}