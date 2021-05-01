<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Pincode;

class PincodeCrudTest extends TestCase
{
    // use RefreshDatabase;
   

    public function test_check_index_pincode()
    {   
        $this->actingAs(User::factory(['is_admin'=>1])->create());

        $response = $this->get('/admin/pincode');
        $response->assertStatus(200);
    }

    public function test_check_create_pincode_form()
    {   
        $this->actingAs(User::factory(['is_admin'=>1])->create());

        $response = $this->get('/admin/pincode/create');
        $response->assertStatus(200);

    }

    public function test_create_pincode_post()
    {
        $pincode = [
            'pincode'=>742149,
            'state'=>'West Bengal',
            'circle'=>'East',
            'region'=>'East',
            'division'=>'East',
            'district'=>'Murshidabad',
            'taluk'=>'Lalbagh',
        ];

        $this->actingAs(User::factory(['is_admin'=>1])->create());
        $this->assertAuthenticated('web');

        $createPincode = $this->post('/admin/pincode/', $pincode);
        $createPincode->assertStatus(302);


    }

    public function test_pincode_check_view_and_edit()
    {
        

        $this->actingAs(User::factory(['is_admin'=>1])->create());
        $this->assertAuthenticated('web');
        
        $createPincode = Pincode::factory()->create();

        $respond = $this->get('/admin/pincode/'. $createPincode->id);

        $respond->assertSee($createPincode->pincode);

        $editRespond = $this->get('/admin/pincode/'. $createPincode->id.'/edit');
        $respond->assertSee($createPincode->pincode);
    }

    public function test_create_pincode_update()
    {
        
        $this->actingAs(User::factory(['is_admin'=>1])->create());
        $this->assertAuthenticated('web');
        
        $createPincode = Pincode::factory()->create();
        $createPincode->pincode = 559870;

        $this->put('/admin/pincode/'. $createPincode->id,$createPincode->toArray());

        $this->assertDatabaseHas('pincodes',['pincode'=>$createPincode->pincode]);
    }

    public function test_create_pincode_delete()
    {
        
        $this->actingAs(User::factory(['is_admin'=>1])->create());
        $this->assertAuthenticated('web');
        
        $createPincode = Pincode::factory()->create();
        
        $responds =  $this->delete('/admin/pincode/'. $createPincode->id,$createPincode->toArray());

        $this->assertDatabaseMissing('pincodes',['id'=>$createPincode->id]);
    }

}
