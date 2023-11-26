<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\Blog\PostSeeder;
use Database\Seeders\Auth\UserRoleSeeder;
use Database\Seeders\Blog\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'email' => 'atra.lim@gmail.com',
            'username' => 'atra_lim',
            'password' => Hash::make('12345678'),
            'name' => 'Atra Lim',
            'mobile' => '085344556677',
            'date_of_birth' => '1992-07-16',
            'gender' => 'LK',
            'organization_id' => 1,
            'avatar' => 'img/default-avatar.jpg',
            'created_by' => 1,
        ]);

        \App\Models\User::factory(5)->create();
        $this->call(UserRoleSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CaborSeeder::class);

        // \App\Models\Cabor::factory(10)->create();


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}
