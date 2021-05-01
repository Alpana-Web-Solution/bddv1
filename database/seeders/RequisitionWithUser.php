<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Requisition;
use App\Models\User;
use App\Models\Donation;
use App\Models\RequisitionComment;

class RequisitionWithUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create some users
    	$users = User::factory()->count(10)->create();

    	// Add a requisition for every user
    	foreach ($users as $user) {
    		$requisition = Requisition::factory(['user_id'=>$user->id])->create();
            // $RComments = RequisitionComment::factory(['user_id'=>$user->id,'requisition_id'=>$requisition->id])->count(1)->create();
    		$donation = Donation::factory(['user_id'=>$user->id,'requisition_id'=>$requisition->id])->create();
    	}
    }
}