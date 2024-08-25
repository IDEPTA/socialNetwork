<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = [];
        for ($i = 0; $i < rand(0, 10); $i++) {
            $images[] = fake()->imageUrl();
        }
        $users = User::pluck("id")->toArray();
        return [
            "title" => fake()->text(10),
            "text" => fake()->text(50),
            "user_id" => fake()->randomElement($users),
            "images" => json_encode($images)
        ];
    }
}
