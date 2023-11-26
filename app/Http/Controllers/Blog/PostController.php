<?php

namespace App\Http\Controllers\Blog;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Blog\Post;
use Illuminate\Http\Request;
use App\Models\Blog\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use App\Http\Resources\Blog\PostResource;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Blog\PostCollection;
use App\Http\Requests\Blog\ArticleAddRequest;
use App\Http\Requests\Blog\ArticleUpdateRequest;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;

class PostController extends Controller
{

    protected $moduleName = "Artikel";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // TODO: fix this
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%")
                        ->orWhere('status', 'LIKE', "%{$value}%")
                        ->orWhere('category.name', 'LIKE', "%{$value}%");
                });
            });
        });

        $numberPaginate = request('perPage') ?? 10;

        if (auth()->user()->hasRole('Superadmin')) {
            $postBy = Post::class;
        } else {
            $postBy = auth()->user()->posts();
        }

        $posts = QueryBuilder::for($postBy)
            ->defaultSort('-id')
            ->allowedSorts([
                'id', 'name', 'category', 'status'
            ])
            ->allowedIncludes('category')
            ->allowedFilters([
                'id', 'name', $globalSearch,
                AllowedFilter::callback('category', function (Builder $query, $value) {
                    $query->whereHas('category');
                })
            ])
            ->paginate($numberPaginate)
            ->withQueryString();

        return Inertia::render(
            'Blog/Post/Index',
            [
                'posts' => new PostCollection($posts),
            ]
        )->table(
            function (InertiaTable $table) {
                $table
                    ->withGlobalSearch()
                    ->defaultSort('-id')
                    ->column(key: 'name', searchable: true, sortable: true, canBeHidden: false, label: 'Judul')
                    ->column(key: 'status_foramted', searchable: false, sortable: true, canBeHidden: true, label: 'Status')
                    ->column(key: 'category', searchable: true, sortable: true, canBeHidden: true, label: 'Kategori')
                    ->column(label: 'Actions')
                    ->selectFilter(key: 'status', label: 'Status', options: [
                        '0' => 'Unpublish',
                        '1' => 'Published',
                        '2' => 'Draft',
                    ]);
            }
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return Inertia::render('Blog/Post/Create', [
            'module_name' => $this->moduleName,
            'categories' => $categories->map(fn ($category) => [
                'id' => $category->id,
                'label' => $category->name,
            ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleAddRequest $request)
    {

        // dump($request->all());
        // exit;
        DB::beginTransaction();

        TODO: // drafting or publish on role how?
        if (!auth()->user()->hasRole('Superadmin')) {
            $approval = 1;
        }

        $post = Post::create([
            "name" => $request->name,
            "intro" => $request->intro,
            "content" => $request->content,
            "type" => 'Artikel',
            "is_featured" => $request->isFeatured,
            "status" => $request->status,
            "approval" => $approval,
            "created_by_name" => auth()->user()->name,
            "created_by_alias" => $request->created_by_alias,
            "category_id" => $request->category_id,
            "meta_title" => $request->meta_title,
            "meta_keywords" => $request->meta_keywords,
            "meta_description" => $request->meta_description,
            "meta_og_image" => $request->meta_og_image,
            "meta_og_url" => $request->meta_og_url,
            "featured_image" => $request->featured_image ? $request->file('featured_image')->store('blog-images') : null,
        ]);

        DB::commit();
        DB::rollBack();

        return redirect()->route('post.index')->with('message', [
            'type' => 'error',
            'text' => 'Artikel telah ditambah!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = new PostResource($post);

        return Inertia::render('Blog/Post/Show', [
            'module_name' => $this->moduleName,
            'post' => [
                'id' => $post->id,
                'name' => $post->name,
                'content' => $post->content,
                'created_by_name' => $post->created_by_name,
                'created_by_alias' => $post->created_by_alias,
                'created_at' => $post->created_at_format,
                'avatar' => $post->user->avatar ? URL::route('image', ['path' => $post->user->avatar, 'w' => 100, 'h' => 100, 'fit' => 'crop', 'filt' => 'greyscale']) : null,
                'user' => $post->user
            ],
        ]);
    }

    public function approve(Post $post)
    {
        if (!auth()->user()->hasRole('Superadmin')) {
            abort404();
        }


        $post->update([
            'approval' => 1
        ]);

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Data telah disetujui!',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();

        return Inertia::render('Blog/Post/Edit', [
            'module_name' => $this->moduleName,
            'post' => new PostResource($post),
            'categories' => $categories->map(fn ($category) => [
                'id' => $category->id,
                'label' => $category->name,
            ]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleUpdateRequest $request, Post $post)
    {

        if ($request->has('approval')) {
            $approval = $request->approval;
        } else {
            $approval = 0;
        }

        $post->update([
            "name" => $request->name,
            "intro" => $request->intro,
            "content" => $request->content,
            "type" => 'Artikel',
            "is_featured" => $request->isFeatured,
            "status" => $request->status,
            "approval" => $approval,
            "created_by_name" => auth()->user()->name,
            "created_by_alias" => $request->created_by_alias,
            "category_id" => $request->category_id,
            "meta_title" => $request->meta_title,
            "meta_keywords" => $request->meta_keywords,
            "meta_description" => $request->meta_description,
            "meta_og_image" => $request->meta_og_image,
            "meta_og_url" => $request->meta_og_url,
        ]);

        if (request()->file('featured_image')) {
            // $post->update(['featured_image' => $request->file('featured_image')->store('blog-images')]);//auto naming file
            $file = $request->file('featured_image');
            $post->update(['featured_image' => $file->storeAs('featured-images', "blogImage-{$post->id}.{$file->getClientOriginalExtension()}")]);
        }

        return redirect()->route('post.index')->with('message', [
            'type' => 'success',
            'text' => 'Data telah diperbarui!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {

        $post->delete();

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Item telah dihapus!',
        ]);
    }
}
