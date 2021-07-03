<?php

namespace Database\Factories;

use App\Models\ListType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ListType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'created_by' => User::factory(),
        ];
    }
}
