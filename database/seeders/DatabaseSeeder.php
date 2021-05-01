<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Pincode;
use App\Models\Requisition;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
        	AdminSeeder::class,
        	RequisitionSeeder::class,
            PincodeSeeder::class,
            DonationSeeder::class,
            // RequisitionWithUser::class
            // UserSeeder::class
        ]);
        

    }
}
