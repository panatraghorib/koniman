<?php

namespace Database\Seeders\Blog;

use App\Models\Blog\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Categories Seed
         * ------------------
         */

        // DB::table('categories')->truncate();
        // echo "Truncate: categories \n";

        Category::factory()->count(20)->create();
        echo " Insert: categories \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
