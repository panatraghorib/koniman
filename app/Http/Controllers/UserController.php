<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Cabor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Inertia\Response;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });

        $numberPaginate = request('perPage') ?? 10;

        $users = QueryBuilder::for(User::whereNot('id', 1))
            ->defaultSort('id')
            ->allowedSorts(['id', 'name', 'email'])
            ->allowedFilters(['id', 'name', 'email', $globalSearch])
            ->paginate($numberPaginate)
            ->withQueryString();


        return Inertia::render('Users/Index', [
            'users' => $users,

        ])->table(
            function (InertiaTable $table) {
                $table
                    ->withGlobalSearch()
                    ->defaultSort('id')
                    ->column(key: 'name', searchable: true, sortable: true, canBeHidden: false, label: 'Nama')
                    ->column(key: 'email', searchable: true, sortable: true)
                    ->column(key: 'email_verified_at', label: 'Bergabung')
                    ->column(label: 'Actions');
            }
        );
    }


    public function sample_user(Request $request): Response
    {
        return Inertia::render('Users/SampleUsers', [
            'role' => Role::all(['id', 'name']),
            'users' => User::tableSearch($request->input('searchObj'))
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $roles = Role::whereNot('id', 1)->orderBy('id')->get();
        return Inertia::render('Users/Create', [
            'roles' => $roles->map(fn ($role) => [
                'id' => $role->id,
                'label' => $role->name,
            ]),
            'cabor' => Cabor::all()->transform(fn ($cabor) => [
                'id' => $cabor->id,
                'label' => $cabor->cabor_name,
            ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserAddRequest $request)
    {

        // $roles = ($request->roles) ?? [];
        // dump($request->all());
        // dump(array_map('intval', $roles));
        // exit;
        DB::beginTransaction();

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'mobile' => $request->mobile,
            'date_of_birth' => $request->dateOfBirth,
            'gender' => $request->gender['id'] ?? $request->gender,
            'organization_id' => $request->cabor,
            'avatar' => $request->file('avatar') ? $request->file('avatar')->store('users') : null,
            'created_by' => auth()->user()->id,
        ]);

        if ($request->has('roles')) {
            $roles = ($request->roles) ?? [];
            $user->assignRole(array_map('intval', $roles));
        }

        activity('User')
            ->causedBy(auth()->user()->id ?? null)
            ->withProperties(['attributes' => $user])
            ->performedOn($user)
            ->event('created')
            ->log('User with Email' . $user->email . ' has been created');

        DB::commit();
        DB::rollBack();

        return redirect()->route('user.index')->with('message', [
            'type' => 'error',
            'text' => 'User telah ditambah!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        $roles = Role::whereNot('id', 1)->orderBy('id')->get(); // bisa di remove kalau diperlukan
        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'name' => $user->name,
                'mobile' => $user->mobile,
                'date_of_birth' => $user->date_of_birth,
                'gender' => $user->gender,
                'organization_id' => $user->organization_id,
                // 'role' => $user->roles()->get(['id','name']),
                'roles' => $user->roles ?? null,
                'avatar' => $user->avatar ? URL::route('image', ['path' => $user->avatar, 'w' => 100, 'h' => 100, 'fit' => 'crop']) : null,
                'created_by' => $user->created_by,
            ],

            'roles' => $roles->map(fn ($role) => [
                'id' => $role->id,
                'label' => $role->name,
            ]),
            'cabor' => Cabor::all()->map(fn ($cabor) => [
                'id' => $cabor->id,
                'label' => $cabor->cabor_name,
            ]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {

        DB::beginTransaction();
        $user->update([
            'email' => $request->email,
            'username' => $request->username,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'date_of_birth' => $request->dateOfBirth,
            'organization_id' => $request->cabor,
        ]);

        if (request()->file('avatar')) {
            $user->update(['avatar' => $request->file('avatar')->store('users')]);
        }

        if ($request->get('password')) {
            $user->update(['password' => $request->get('password')]);
        }

        if ($request->has('roles') && !$user->hasRole('Superadmin')) {
            $roles = $request->roles ?? [];
            $user->syncRoles(array_map('intval', $roles));
        }


        activity('User')
            ->causedBy(auth()->user()->id ?? null)
            ->withProperties(['attributes' => $user])
            ->performedOn($user)
            ->event('created')
            ->log('User with Email' . $user->email . ' has been updated');

        DB::commit();
        DB::rollBack();

        return redirect()->route('user.index')->with('message', [
            'type' => 'success',
            'text' => 'User telah diperbarui!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        if (auth()->user()->id == $user->id || $user->id == 1 || $user->hasRole('Superadmin')) {
            return redirect()->route('user.index')->with('message', [
                'type' => 'danger',
                'text' => 'You cannot delete your self!',
            ]);
        }
        $user->delete();

        activity('User')
            ->causedBy(auth()->user()->id ?? null)
            ->withProperties(['attributes' => $user])
            ->performedOn($user)
            ->event('created')
            ->log('User with Email' . $user->email . ' has been deleted');

        return redirect()->route('user.index')->with('message', [
            'type' => 'error',
            'text' => 'User telah dihapus!',
        ]);
    }
}
