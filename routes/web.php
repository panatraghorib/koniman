<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CaborController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\Blog\CategoryController;

Route::get('/', function () {
    return Inertia::render('Frontend/Home', [
        'canLogin' => Route::has('login'),
        // 'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/forms', function () {
    return Inertia::render('FormsView');
})->middleware(['auth', 'verified'])->name('forms');

Route::middleware('auth')->group(function () {

    #DASHBOARD ROUTE
    Route::get('/dashboard', function () {
        return Inertia::render('HomeView');
    })->middleware(['verified'])->name('dashboard');

    #PROFILE ROUTES
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    #USERS ROUTES
    Route::group(['prefix' => 'users'], function () {
        // Route::resource('users', UserController::class);
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/sampleuser', [UserController::class, 'sample_user'])->name('user.sample');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('delete/{user}', [UserController::class, 'destroy'])->name('user.delete');
    });

    #Cabor ROUTES
    Route::group(['prefix' => 'data-cabor'], function () {
        Route::get('/', [CaborController::class, 'index'])->name('cabor.index');
        Route::get('create', [CaborController::class, 'create'])->name('cabor.create');
        Route::post('store', [CaborController::class, 'store'])->name('cabor.store');
        Route::get('{cabor}/edit', [CaborController::class, 'edit'])->name('cabor.edit');
        Route::put('update/{cabor}', [CaborController::class, 'update'])->name('cabor.update');
        Route::delete('delete/{cabor}', [CaborController::class, 'destroy'])->name('cabor.delete');
    });

    #Article Blog ROUTES
    Route::group(['prefix' => 'blog'], function () {
        #Category
        Route::get('category/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('category/update/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('category/delete/{category}', [CategoryController::class, 'destroy'])->name('category.delete');

        #Post
        Route::get('posts/', [PostController::class, 'index'])->name('post.index');
        Route::get('post/create', [PostController::class, 'create'])->name('post.create');
        Route::post('post/store', [PostController::class, 'store'])->name('post.store');
        Route::get('post/{post}/show', [PostController::class, 'show'])->name('post.show');
        Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
        Route::put('post/update/{post}', [PostController::class, 'update'])->name('post.update');
        Route::put('post/approve/{post}', [PostController::class, 'approve'])->name('post.approve');
        Route::delete('post/delete/{post}', [PostController::class, 'destroy'])->name('post.delete');
    });


    Route::post('upload-image', [ImageUploadController::class, 'upload'])->name('image.upload');
    Route::post('delete-image', [ImageUploadController::class, 'delete'])->name('image.delete');
});



Route::get('/test-front', function () {
    return Inertia::render('Frontend/Index');
});


// Images
Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

require __DIR__ . '/auth.php';
