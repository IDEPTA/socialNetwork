<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\PostLike;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Post::factory(10)->create();
        Comment::factory(10)->create();
        PostLike::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Прокопчук Сергей Александрович',
        //     'email' => 'test@yandex.ru',
        // ]);
    }
}