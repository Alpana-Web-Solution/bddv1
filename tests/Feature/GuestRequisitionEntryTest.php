<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GuestRequisitionEntryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_guest_show_requisition_form()
    {
        $response = $this->get('/requisition/create');

        $response->assertStatus(200);
    }

    public function test_guest_create_requisition_form()
    {
        $response = $this->withHeaders(['accept'=>'application/json'])
        ->post('/requisition',[
            "pincode" => "458956",
            "hospital_name" => "Ciara Welch",
            "patient_name" => "Rhona Blackwell",
            "contact_name" => "3860657884",
            "donation_type" => "3",
            "blood_group" => "7",
            "unit" => "8",
            "contact" => "8795635968",
            "alternate_contact" => "9863596359",
            "message" => "Ut tempor temporibus",
            "priority" => "2",
            "when_wanted" => "2012-02-17",
            'when_wanted_time'=>"19:52:00"
        ]);

        // $response->dump();
        $response
        ->assertStatus(302)
        ->assertHeader('Location', url('/requisition'));
        
        $this->get('/requisition')->assertSeeText('AB+');
        
        
    }

    
}
