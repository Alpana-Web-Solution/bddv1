<?php

namespace Database\Factories;

use App\Models\Donation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Donation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id"=>"1",
            "requisition_id"=>"1",
            "type"=>1,
            "unit"=>1,
            "approver_id"=>1,
            "comment"=>"Thank You",
            "date"=>now()
        ];
    }
}
