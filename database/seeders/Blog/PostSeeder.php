<?php

namespace Database\Seeders\Blog;

use App\Models\Blog\Post;
use App\Models\Blog\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Auth::loginUsingId(1);

        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Category Seed
         * ------------------
         */
        DB::table(config('apptra.database.prefix') . 'categories')->truncate();
        echo "\nTruncate: categories \n";

        Category::factory()->count(5)->create();
        echo " Insert: categories \n\n";

        /*
         * Posts Seed
         * ------------------
         */
        DB::table(config('apptra.database.prefix') . 'posts')->truncate();
        echo "Truncate: posts \n";

        // Populate the pivot table
        Post::factory()
            ->count(10)
            ->create();
        echo " Insert: posts \n\n";

        Artisan::call('auth:permission', [
            'name' => 'post',
        ]);
        Artisan::call('auth:permission', [
            'name' => 'category',
        ]);

        // Artisan::call('auth:permission', [
        //     'name' => 'tags',
        // ]);

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
