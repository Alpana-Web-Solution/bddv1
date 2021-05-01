<?php

namespace Database\Factories;

use App\Models\RequisitionComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequisitionCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RequisitionComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'user_id'=> 1,
            // 'requisition_id'=>1,
            // 'comment' => $this->faker()->sentence,
            // 'request_type'=>0
        ];
    }
}
