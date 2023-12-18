<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CaborController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Resources\Cabor\CaborResource;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\Blog\CategoryController;
use App\Http\Controllers\Frontend\HomeController;

// Route::get('/', function () {
//     return Inertia::render('Frontend/HomeSlider', [
//         'canLogin' => Route::has('login'),
//         // 'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

#FRONTEND
Route::get('/', HomeController::class);
#END FRONTEND

Route::get('/forms', function () {
    return Inertia::render('FormsView');
})->middleware(['auth', 'verified'])->name('forms');

Route::middleware('auth')->group(function () {

    #DASHBOARD ROUTE
    Route::get('/dashboard', function () {
        $infoUser = auth()->user()?->cabor()?->first();

        return Inertia::render('HomeView', [
            'caborName' => optional($infoUser)->cabor_name
        ]);
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

    #CKEditor Imaga Upload
    Route::post('upload-image', [ImageUploadController::class, 'upload'])->name('image.upload');
    Route::post('delete-image', [ImageUploadController::class, 'delete'])->name('image.delete');

    #Setting
    Route::group(['prefix' => 'settings'], function () {
        Route::group(['prefix' => 'app'], function () {
            Route::get('general', [SettingController::class, 'index'])->name('general.edit');
            Route::put('general/update', [SettingController::class, 'store'])->name('general.store');
        });

        //ROLES
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('role.index');
            Route::get('add', [RoleController::class, 'create'])->name('role.create');
            Route::post('store', [RoleController::class, 'store'])->name('role.store');
            Route::get('{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
            Route::put('update/{role}', [RoleController::class, 'update'])->name('role.update');
            Route::delete('delete/{role}', [RoleController::class, 'destroy'])->name('role.delete');
        });

        //PERMISSIONS
        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', [PermissionController::class, 'index'])->name('permission.index');
        });
    });
});



Route::get('/test-front', function () {
    return Inertia::render('Frontend/Index');
});


// Images
Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

#Locale
Route::get('/trans/{locale}', function (string $locale) {
    if (!in_array($locale, ['en', 'id'])) {
        abort(400);
    }

    App::setLocale($locale);

    return redirect()->back()->with('message', [
        'type' => 'error',
        'text' => 'Translated',
    ]);
})->name('trans');

Route::get('/setLang/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return back();
})->name('setlang');

require __DIR__ . '/auth.php';
