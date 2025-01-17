<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/', [PostController::class, 'index']);
Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
Route::post('/posts', [PostController::class, 'store'])->name('post.store');
Route::get('/posts', [PostController::class, 'getData'])->name('posts.getData');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');

//Route::post('/posts', 'PostController@store')->name('post.store');
//Route::get('/posts/create', 'PostController@create')->name('post.create');

