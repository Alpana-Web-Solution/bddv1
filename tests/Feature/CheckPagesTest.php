<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckPagesTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_landing_page_show_test()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

    }
    
    public function test_home_page_show_test()
    {
        $response = $this->get('/home');

        $response->assertStatus(200);
    }
    
    public function test_about_page_show_test()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }
    
    public function test_contact_page_show_test()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }
    
    public function test_requisition_create_test()
    {
        $response = $this->get('/requisition/create');

        $response->assertStatus(200);
    }

    public function test_registration_link_from_home()
    {
       $respond = $this->view('home');

       $respond->assertSee('alpana');
   }
}
