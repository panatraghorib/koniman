<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use App\Models\Blog\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Resources\Blog\PostCollection;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $post = Post::with('category')->published()->get();

        return Inertia::render('Frontend/HomeSlider', [
            'hero' => collect($post)->take(5),
            'allposts' => new PostCollection($post),
            'canLogin' => Route::has('login'),
            // 'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}
