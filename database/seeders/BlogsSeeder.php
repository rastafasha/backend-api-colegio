<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogs = [
            [
                'user_id' => 2, // admin
                'title' => 'Welcome to Our Blog',
                'description' => 'This is the first post on our blog, created by the admin.',
                'author' => 'Admin',
                'is_active' => true,
                'avatar' => null,
                'slug' => Str::slug('Welcome to Our Blog'),
                'favorite_id' => null,
                'is_featured' => true,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 11, // maestro
                'title' => 'Teaching Tips for Success',
                'description' => 'Helpful tips for teachers to succeed in the classroom.',
                'author' => 'Maestro',
                'is_active' => true,
                'avatar' => null,
                'slug' => Str::slug('Teaching Tips for Success'),
                'favorite_id' => null,
                'is_featured' => false,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // admin
                'title' => 'Latest Technology Trends',
                'description' => 'An overview of the latest trends in technology.',
                'author' => 'Admin',
                'is_active' => true,
                'avatar' => null,
                'slug' => Str::slug('Latest Technology Trends'),
                'favorite_id' => null,
                'is_featured' => false,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 11, // maestro
                'title' => 'Classroom Management Strategies',
                'description' => 'Effective strategies for managing a classroom.',
                'author' => 'Maestro',
                'is_active' => true,
                'avatar' => null,
                'slug' => Str::slug('Classroom Management Strategies'),
                'favorite_id' => null,
                'is_featured' => false,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // admin
                'title' => 'Health and Wellness Tips',
                'description' => 'Tips for maintaining health and wellness.',
                'author' => 'Admin',
                'is_active' => true,
                'avatar' => null,
                'slug' => Str::slug('Health and Wellness Tips'),
                'favorite_id' => null,
                'is_featured' => false,
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('blogs')->insert($blogs);
    }
}
