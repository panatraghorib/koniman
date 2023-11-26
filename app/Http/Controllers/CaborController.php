<?php

namespace App\Http\Controllers;

use App\Http\Resources\Cabor\CaborCollection;
use App\Http\Resources\Cabor\CaborResource;
use Inertia\Inertia;
use App\Models\Cabor;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;

class CaborController extends Controller
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
                        ->orWhere('cabor_name', 'LIKE', "%{$value}%")
                        ->orWhere('initial', 'LIKE', "%{$value}%");
                });
            });
        });

        $numberPaginate = request('perPage') ?? 10;

        $cabor = QueryBuilder::for(Cabor::class)
            ->defaultSort('id')
            ->allowedSorts(['id', 'cabor_name', 'initial'])
            ->allowedFilters(['id', 'cabor_name', 'initial', $globalSearch])
            ->paginate($numberPaginate)
            ->withQueryString();


        return Inertia::render('Cabor/Index', [
            'cabor' => new CaborCollection($cabor),
        ])->table(
            function (InertiaTable $table) {
                $table
                    ->withGlobalSearch()
                    ->defaultSort('id')
                    ->column(key: 'cabor_name', searchable: true, sortable: true, canBeHidden: false, label: 'Cabor/Organisasi')
                    ->column(key: 'initial', searchable: true, sortable: true)
                    ->column(key: 'logo', searchable: false, sortable: false)
                    ->column(label: 'Actions');
            }
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Cabor/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();

        $request->validate([
            'cabor_name' => ['required', 'string', 'min:5'],
            'initial' => ['required', 'string'],
            'logo' => ['nullable']
        ]);

        $cabor = Cabor::create([
            'cabor_name' => $request->cabor_name,
            'initial' => $request->initial,
            'logo' => $request->file('logo') ? $request->file('logo')->store('cabor') : null,
            'created_by' => auth()->user()->id,
        ]);

        activity('Cabor')
            ->causedBy(auth()->user()->id ?? null)
            ->withProperties(['attributes' => $cabor])
            ->performedOn($cabor)
            ->event('created')
            ->log('Data ' . $cabor->cabor_name . ' has been created');

        DB::commit();
        DB::rollBack();

        return redirect()->route('cabor.index')->with('message', [
            'type' => 'success',
            'text' => 'Data telah ditsimpan!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabor $cabor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cabor $cabor)
    {
        return Inertia::render('Cabor/Edit', [
            // 'cabor' => [
            // 'id' => $cabor->id,
            // 'cabor_name' => $cabor->cabor_name,
            // 'initial' => $cabor->initial,
            // 'logo' => $cabor->logo ? URL::route('image', ['path' => $cabor->logo, 'w' => 100, 'h' => 100, 'fit' => 'crop']) : null,
            // ],
            'cabor' => new CaborResource($cabor),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cabor $cabor)
    {
        DB::beginTransaction();

        $request->validate([
            'cabor_name' => ['required', 'string', 'min:5'],
            'initial' => ['required', 'string'],
            'logo' => ['nullable']
        ]);

        $cabor->update([
            'cabor_name' => $request->cabor_name,
            'initial' => $request->initial,
            'updated_by' => auth()->user()->id,
        ]);

        if (request()->file('logo')) {
            $cabor->update(['logo' => $request->file('logo')->store('cabor')]);
        }

        activity('Cabor')
            ->causedBy(auth()->user()->id ?? null)
            ->withProperties(['attributes' => $cabor])
            ->performedOn($cabor)
            ->event('created')
            ->log('Data ' . $cabor->cabor_name . ' has been updated');

        DB::commit();
        DB::rollBack();

        return redirect()->route('cabor.index')->with('message', [
            'type' => 'success',
            'text' => 'User telah diperbarui!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabor $cabor)
    {

        // TODO: canot delete when model has any relationship

        // $cabor->hasRelations('users', 'atlet', 'articles')
        if ($cabor->hasRelations('users')) {
            return redirect()->route('cabor.index')->with('message', [
                'type' => 'error',
                'text' => 'Tidak Dapat Menghapus Cabor!',
            ]);
        }

        $cabor->delete();

        activity('Cabor')
            ->causedBy(auth()->user()->id ?? null)
            ->withProperties(['attributes' => $cabor])
            ->performedOn($cabor)
            ->event('created')
            ->log('Cabor with' . $cabor->cabor_name . ' has been deleted');

        return redirect()->route('cabor.index')->with('message', [
            'type' => 'success',
            'text' => 'Cabor telah dihapus!',
        ]);
    }
}
