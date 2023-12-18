<?php

namespace App\Models;


class Permission extends \Spatie\Permission\Models\Permission
{

    public static function defaultPermissions()
    {

        return [
            'view_user',
            'add_user',
            'edit_user',
            'delete_user',
            'restore_user',
            'block_user',

            'view_role',
            'add_role',
            'edit_role',
            'delete_role',
            'restore_role',

            'view_backup',
            'add_backup',
            'create_backup',
            'download_backup',
            'delete_backup',
        ];
    }
}
