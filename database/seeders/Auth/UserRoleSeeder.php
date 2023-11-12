<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        User::findOrFail(1)->assignRole('Superadmin');
        User::findOrFail(2)->assignRole('Koni');
        User::findOrFail(3)->assignRole('Organisasi/Cabor');
        User::findOrFail(4)->assignRole('Eksternal');

        Schema::enableForeignKeyConstraints();
    }
}
