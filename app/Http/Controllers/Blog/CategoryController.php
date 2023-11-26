<?php

namespace App\Http\Controllers\Blog;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Blog\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request as FacadeRequest;

class CategoryController extends Controller
{

    protected $moduleName = "Kategori";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Blog/Category/Index', [
            'module_name' => $this->moduleName,
            'filters' => FacadeRequest::all('search', 'trashed'),
            'categories' => Category::orderBy('name')
                ->filter(FacadeRequest::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($category) => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => $category->image ? URL::route('image', ['path' => $category->image, 'w' => 100, 'h' => 100, 'fit' => 'crop']) : null,
                    'deleted_at' => $category->deleted_at,
                ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Blog/Category/Create', [
            'module_name' => $this->moduleName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'name' => ['required', 'string', 'min:5', 'unique:App\Models\Blog\Category,name'],
            'image' => ['nullable']
        ]);

        $category = Category::create([
            'name' => $request->name,
            'image' => $request->file('image') ? $request->file('image')->store('categories') : null,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
            'status' => $request->status,
            'created_by' => auth()->user()->id,
        ]);

        activity('Blog Kategory')
            ->causedBy(auth()->user()->id ?? null)
            ->withProperties(['attributes' => $category])
            ->performedOn($category)
            ->event('created')
            ->log('Data ' . $category->name . ' has been created');

        DB::commit();
        DB::rollBack();

        return redirect()->route('category.index')->with('message', [
            'type' => 'success',
            'text' => 'Data telah ditsimpan!',
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
    public function edit(Category $category)
    {
        return Inertia::render('Blog/Category/Edit', [
            'module_name' => $this->moduleName,
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'group_name' => $category->group_name,
                'image' => $category->image ? URL::route(
                    'image',
                    ['path' => $category->image, 'w' => 100, 'h' => 100, 'fit' => 'crop']
                ) : null,
                'meta_title' => $category->meta_title,
                'meta_description' => $category->meta_description,
                'meta_keyword' => $category->meta_keyword,
                'status' => $category->status,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'unique:App\Models\Blog\Category,name,' . $category->id],
            'image' => ['nullable']
        ]);

        $category->update([
            'name' => $request->name,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
            'status' => $request->status,
            'updated_by' => auth()->user()->id,
        ]);

        if (request()->file('image')) {
            $category->update(['image' => $request->file('image')->store('categories')]);
        }

        activity('Blog Kategory')
            ->causedBy(auth()->user()->id ?? null)
            ->withProperties(['attributes' => $category])
            ->performedOn($category)
            ->event('updated')
            ->log('Data ' . $category->name . ' has been updated');

        DB::commit();
        DB::rollBack();

        return redirect()->route('category.index')->with('message', [
            'type' => 'success',
            'text' => 'Data telah diperbarui!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        if ($category->hasRelations('posts')) {
            return redirect()->route('category.index')->with('message', [
                'type' => 'error',
                'text' => 'Tidak Dapat Menghapus Category!',
            ]);
        }

        $category->delete();

        activity('Category')
            ->causedBy(auth()->user()->id ?? null)
            ->withProperties(['attributes' => $category])
            ->performedOn($category)
            ->event('created')
            ->log('Category with' . $category->name . ' has been deleted');

        return redirect()->route('category.index')->with('message', [
            'type' => 'success',
            'text' => 'Category telah dihapus!',
        ]);
    }
}
