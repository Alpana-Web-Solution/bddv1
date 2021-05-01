<?php

namespace Database\Factories;

use App\Models\Requisition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RequisitionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Requisition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "pincode" => rand(100000,999999),
            "hospital_name" => Str::random(10) . " Hospital",
            "patient_name" => $this->faker->name,
            "contact_name" => $this->faker->name,
            "donation_type" => "1",
            "blood_group" => rand(1,8),
            "unit" => "1",
            "contact" => rand(7800000000,9999999999),
            "alternate_contact" => rand(7800000000,9999999999),
            "message" => $this->faker->sentence,
            "priority" => "1",
            "when_wanted" => now(),
        ];
    }
}
