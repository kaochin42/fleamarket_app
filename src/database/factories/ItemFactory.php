<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Condition;

class ItemFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'condition_id' => Condition::inRandomOrder()->first()->id,
            'name' => $this->faker->word(),
            'brand_name' => $this->faker->company(),
            'description' => $this->faker->text(),
            'image_path' => $this->faker->imageUrl(),
            'price' => $this->faker->numberBetween(100, 50000),
        ];
    }
}
