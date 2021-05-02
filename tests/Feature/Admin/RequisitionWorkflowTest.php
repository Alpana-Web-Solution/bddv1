<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\RequisitionComment;
use App\Models\Requisition;
use App\Models\Donation;


class RequisitionWorkflowTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_full_requisition_crud_test()
    {
        $this->actingAs(User::factory(['name'=>'D Biswas','is_admin'=>1])->create());
        $this->assertAuthenticated('web');
        //1. Create a requisition
        $requisitionResponse = Requisition::factory(['user_id'=> auth()->user()->id])->create();
        $requisitionID = $requisitionResponse->id;

        $requisitionResponse = $this->get('/admin/requisition/'.$requisitionID);
        $requisitionResponse->assertStatus(200);

        //2. Create comments for requisition
        $commentInsert = ['user_id'=> auth()->user()->id,'requisition_id'=>$requisitionID,'comment' => 'Manual Comment','request_type'=>0,'type'=>0];

        $rCommentResponse = $this->post('/requisition/'.$requisitionID.'/comment',$commentInsert);
        $rCommentResponse->assertStatus(302);

        $requisitionResponseCheck = $this->get('/admin/requisition/'.$requisitionID);
        $requisitionResponseCheck->assertSee('Manual Comment');
        // $rCommentResponse->assertStatus(302);

        // 3. Blood Donation see field
        $checkRequisitionBloodDonation = $this->get('admin/requisition/'.$requisitionID.'/donation');
        $checkRequisitionBloodDonation->assertStatus(200);

        // 3.1 Add Blood Donation
        $insertBloodDonation = Donation::factory([
            'user_id'=>auth()->user()->id,
            'requisition_id'=>$requisitionID,
            'approver_id'=>auth()->user()->id,
        ])->create();

        // Check Requisition's donation is present
        $checkBloodDonation = $this->get('/admin/requisition/'.$requisitionID.'/donation');
        $checkBloodDonation->assertSee(auth()->user()->name);

        // Donation request
        $testUser1 = User::factory(['name'=>'Test Biswas'])->create();
        
        // $insertNonConfirmedBloodDonationRequest 
        $insertNonConfirmedBloodDonationRequestData = ['user_id'=> $testUser1->id,'requisition_id'=>$requisitionID,
        'comment' => 'Blood Donation msg?','type'=>1];
        
        $insertNonConfirmedBloodDonationResponse = $this->post('/requisition/'.$requisitionID.'/comment',$insertNonConfirmedBloodDonationRequestData);
        $insertNonConfirmedBloodDonationResponse->assertStatus(302);

        // Check if ? found in the view
        $insertNonConfirmedBloodDonationRequest = $this->get('/admin/requisition/'.$requisitionID.'/donation');
        $insertNonConfirmedBloodDonationRequest->assertSee(" ?");

        // Check admin/requisition/?/comment/
        $CCABDResponse = $this->get('/admin/requisition/'.$requisitionID.'/comment');
        $CCABDResponse->assertSee("Blood Donation msg?");

        // Delete this requisition.
        $deleteRequisition = $this->delete('/admin/requisition/'.$requisitionID);
        $this->assertDatabaseMissing('requisitions',['id'=> $requisitionID]);

    }
}
