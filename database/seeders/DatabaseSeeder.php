<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(5)->create();

         \App\Models\User::factory()->create([
             'name' => 'user',
             'email' => 'user@example.com',
         ]);

        \App\Models\Admin::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

       $author =  \App\Models\Author::create([
            'name' => 'author',
            'email' => 'author@example.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\Post::create([
            'author_id' => $author->id,
            'title' => 'mustafa wooow',
            'content' => 'Mustafa is super super woooow',
            'status' => 'approved',
        ]);

        \App\Models\Post::create([
            'author_id' => $author->id,
            'title' => 'mustafa wooow 2',
            'content' => 'Mustafa is super super woooow 2 ',
            'status' => 'approved',
        ]);


        \App\Models\Tag::create([
            'name' => 'personality',
        ]);

        \App\Models\Tag::create([
            'name' => 'laravel',
        ]);

        \App\Models\Category::create([
            'name' => 'educational',
        ]);
    }
}
