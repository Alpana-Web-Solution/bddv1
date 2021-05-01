<?php

namespace Database\Factories;

use App\Models\Pincode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class PincodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pincode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pincode'=>rand(100000,999999),
            'state'=>Str::random(10),
            'circle'=>Str::random(10),
            'region'=>Str::random(10),
            'division'=>Str::random(10),
            'district'=>Str::random(10),
            'taluk'=>Str::random(10)
        ];
    }
}
