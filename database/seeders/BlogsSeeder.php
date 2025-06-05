<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class BlogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch user IDs dynamically
        $adminUser = User::where('email', 'admin@admin.com')->first();
        $maestroUser = User::where('email', 'maestro@maestro.com')->first();

        $adminUserId = $adminUser ? $adminUser->id : null;
        $maestroUserId = $maestroUser ? $maestroUser->id : null;

        $blogs = [
            [
                'user_id' => $adminUserId,
                'title' => 'Welcome to Our Blog',
                'description' => 'This is the first post on our blog, created by the admin.',
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
                'user_id' => $maestroUserId,
                'title' => 'Teaching Tips for Success',
                'description' => 'Helpful tips for teachers to succeed in the classroom.',
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
                'user_id' => $adminUserId,
                'title' => 'Latest Technology Trends',
                'description' => 'An overview of the latest trends in technology.',
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
                'user_id' => $maestroUserId,
                'title' => 'Classroom Management Strategies',
                'description' => 'Effective strategies for managing a classroom.',
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
                'user_id' => $adminUserId,
                'title' => 'Health and Wellness Tips',
                'description' => 'Tips for maintaining health and wellness.',
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
