<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'question_id'=> 1,
            'op1'=> $this->faker->word,
            'op2'=> $this->faker->word,
            'op3'=> $this->faker->word,
            'op4'=> $this->faker->word,
            'correct_ans' => collect(['op1','op2','op3','op4'])->random()
        ];
    }
}
