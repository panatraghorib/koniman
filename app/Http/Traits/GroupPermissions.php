<?php

namespace App\Http\Traits;

use App\Support\Settings;
use App\Models\Permission;

trait GroupPermissions
{
    public function getPermissionsGroup()
    {
        //Buat permissions Grup (masih manual)
        $permissionsGroup = Settings::getPermissionsGroup();
        //Daftar permissions
        $allPermissions = Permission::all()->pluck('name', 'id');

        // Proses untuk mengelompokkan permissions
        foreach ($allPermissions as $permission) {
            // Explode string permission untuk mendapatkan grup dan nama permission
            $permissionParts = explode('_', $permission, 2); // Maksimal explode hanya sebanyak 2 bagian

            if (count($permissionParts) === 2) {
                $group = $permissionParts[1]; // Grup permission dari hasil explode
                $namaPermission = $permissionParts[0]; // Nama permission dari hasil explode

                // Cocokkan grup dengan kunci array permissions
                if (array_key_exists($group, $permissionsGroup)) {
                    // Tambahkan nama permission ke grup yang sesuai
                    $permissionsGroup[$group][$permission] = $namaPermission;
                }
            }
        }

        return $permissionsGroup;
    }
}
