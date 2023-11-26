<?php

namespace Database\Seeders\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $super_admin = Role::create(['id' => '1', 'name' => 'Superadmin']); // Admin Koni
        $koni = Role::create(['id' => '2', 'name' => 'Koni']); //Eksekutif Koni
        $cabor = Role::create(['id' => '3', 'name' => 'Organisasi/Cabor']); // Organisasi/Cabor
        $eksternal = Role::create(['id' => '4', 'name' => 'Eksternal']); //OPD (Dispora)
        echo "\n Roles Created.";

        User::findOrFail(1)->assignRole('Superadmin');
        User::findOrFail(2)->assignRole('Koni');
        User::findOrFail(3)->assignRole('Organisasi/Cabor');
        User::findOrFail(4)->assignRole('Eksternal');
        User::findOrFail(5)->assignRole('Koni');

        echo "\n Asign User Role.";

        Permission::firstOrCreate(['name' => 'view_backend']);
        Permission::firstOrCreate(['name' => 'edit_settings']);
        Permission::firstOrCreate(['name' => 'view_logs']);

        $koniPermission1 = Permission::firstOrCreate(['name' => 'view_cabor']);
        $koniPermission2 = Permission::firstOrCreate(['name' => 'edit_cabor']);
        $koniPermission3 = Permission::firstOrCreate(['name' => 'read_cabor']);
        $koniPermission4 = Permission::firstOrCreate(['name' => 'delete_cabor']);
        $koniPermission5 = Permission::firstOrCreate(['name' => 'restore_cabor']);

        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        Artisan::call('auth:permission', [
            'name' => 'post',
        ]);

        echo "\n _Posts_ Permissions Created.";

        Artisan::call('auth:permission', [
            'name' => 'category',
        ]);

        echo "\n _Categories_ Permissions Created.";
        echo "\n\n";

        // Assign Permissions to Roles
        $super_admin->givePermissionTo(Permission::all());
        $cabor->givePermissionTo([$koniPermission1, $koniPermission2, $koniPermission3, $koniPermission4, $koniPermission5]);


        Schema::enableForeignKeyConstraints();
    }
}
