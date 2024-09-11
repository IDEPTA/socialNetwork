<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            "text" => fake()->text(100),
            "user_id" => fake()->randomElement($users),
            "post_id" => fake()->randomElement($posts),
            "created_at" => Carbon::today()->subDay(rand(1, 30)),
        ];
    }
}
