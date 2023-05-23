<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $posts = Post::all();
    return view('welcome', compact('posts'));
});


// /admin/posts/......
Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        // ->prefix('admin') concatenato con '/'
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); //dashboard
        Route::resource('posts', PostController::class)->parameters([
            'posts' => 'post:slug' //https://laravel.com/docs/9.x/controllers#restful-naming-resource-route-parameters
        ]);
    });

Route::middleware('auth')
    ->name('profile.')
    ->prefix('profile')
    ->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';
