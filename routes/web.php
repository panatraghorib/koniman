<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
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
});


// Images

Route::get('/test-front', function () {
    return Inertia::render('Frontend/Index');
});

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

require __DIR__ . '/auth.php';
