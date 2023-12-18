<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Inertia\Inertia;
use App\Authorizable;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\GroupPermissions;
use Illuminate\Support\Facades\Request as FacadeRequest;

class RoleController extends Controller
{
    use GroupPermissions;
    use Authorizable;

    protected $moduleName = "Roles";

    public function index(): Response
    {

        return Inertia::render('Settings/Roles/RoleIndex', [
            'module_name' => $this->moduleName,
            'filters' => FacadeRequest::all('search'),
            'roles' => Role::whereNotIn('name', ['Superadmin'])->orderBy('name')
                ->filter(FacadeRequest::only('search'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($category) => [
                    'id' => $category->id,
                    'name' => $category->name,
                ]),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Settings/Roles/RoleAdd', [
            'module_name' => $this->moduleName,
            'group_permissions' => $this->getPermissionsGroup()
        ]);
    }
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $request->validate([
                'name' => ['required', 'string', 'max:35']
            ]);

            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);

            $permissions = ($request->permissions) ?? [];
            $role->syncPermissions($permissions);
        });

        return to_route('role.index')->with('message', [
            'type' => 'success',
            'text' => 'User telah diperbarui!',
        ]);
    }

    public function edit(Role $role): Response
    {

        $rolePermissions = [
            'data' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                    ];
                })->toArray(),
            ],
        ];

        return Inertia::render('Settings/Roles/RoleEdit', [
            'module_name' => $this->moduleName,
            'role' => $rolePermissions,
            'group_permissions' => $this->getPermissionsGroup()
        ]);
    }

    public function update(Request $request, Role $role)
    {

        DB::transaction(function () use ($request, $role) {

            $role->update($request->validate([
                'name' => ['required', 'string', 'max:35']
            ]));

            $permissions = ($request->permissions) ?? [];
            $role->syncPermissions($permissions);
        });

        return to_route('role.index')->with('message', [
            'type' => 'success',
            'text' => 'User telah diperbarui!',
        ]);
    }

    public function destroy(Role $role)
    {

        $user_roles = auth()->user()->roles()->pluck('id');
        $role_users = $role->users;

        if ($role->id === 1 || $role->name == 'Superadmin') {

            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'You can not delete Administrator!',
            ]);
        }

        if (in_array($role->id, $user_roles->toArray())) {

            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'You can not delete your Role!',
            ]);
        }

        if ($role_users->count()) {

            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'Can not be deleted!',
            ]);
        }

        $role->delete();

        activity('Role')
            ->causedBy(auth()->user()->id ?? null)
            ->withProperties(['attributes' => $role])
            ->performedOn($role)
            ->event('deleted')
            ->log('Role with name ' . $role->name . ' has been deleted');

        return redirect()->route('role.index')->with('message', [
            'type' => 'success',
            'text' => 'Item telah dihapus!',
        ]);
    }
}
