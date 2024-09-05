<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostLike>
 */
class PostLikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::pluck("id")->toArray();
        $posts = Post::pluck("id")->toArray();
        return [
            "user_id" => fake()->randomElement($users),
            "post_id" => fake()->randomElement($posts),
            "feedback_type" => fake()->randomElement([true, false]),
        ];
    }
}
