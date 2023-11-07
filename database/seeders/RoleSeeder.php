<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Superadmin']);
        Role::create(['name' => 'Koni']);
        Role::create(['name' => 'Organisasi/Cabor']);
        Role::create(['name' => 'Eksternal']);
    }
}
