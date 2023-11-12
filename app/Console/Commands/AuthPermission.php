<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use App\Models\Permission;

class AuthPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:permission {name} {--R|remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Permissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permissions = $this->generatePermissions();

        $isRemove = $this->option('remove');

        if ($isRemove) {
            if (Permission::where('name', 'LIKE', '%' . $this->getArgument())->delete() . '%') {
                $this->warn('Permission' . implode(', ', $permissions) . ' deleted');
            } else {
                $this->warn('No permissions for' . $this->getNameArgument() . ' found!');
            }
        } else {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }
            $this->info('Permissions ' . implode(', ', $permissions) . ' created.');
        }

        // if ($role = Role::where('name', 'administrator')->first()) {
        //     $role->syncPermissions(Permission::all());
        //     $this->info('Admin Permissions Updated.');
        // }
    }

    private function getArgument()
    {
        return strtolower(Str::plural($this->argument('name')));
    }
    private function generatePermissions()
    {
        $abilities = [
            'view',
            'create',
            'edit',
            'show',
            'approve',
            'delete',
            'restore',
        ];
        // $name = $this->getArgument();
        $name = strtolower($this->argument('name'));

        return array_map(function ($val) use ($name) {
            return $val . '_' . $name;
        }, $abilities);
    }
}
