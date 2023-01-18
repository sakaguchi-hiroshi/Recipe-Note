<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeNoteController;
use App\Http\Controllers\MyrecipeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ManagementController;

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

Route::get('/', [RecipeNoteController::class, 'index'])->name('recipenotes.index');

Route::get('/services/premium', [RecipeNoteController::class, 'showPremiumService'])->name('recipenotes.service');

Route::middleware('auth')->group(function() {

    Route::get('/logout', [AuthController::class,'getLogout']);

    Route::group(['prefix' => '/myrecipes'], function() {
        Route::get('/form', [MyrecipeController::class, 'showForm'])->name('myrecipes.form');
        Route::post('/add', [MyrecipeController::class, 'add']);
        Route::post('/image/delete', [MyrecipeController::class, 'imageDelete']);
        Route::post('/movie/delete', [MyrecipeController::class, 'movieDelete']);
        Route::post('/show', [MyrecipeController::class, 'show'])->name('myrecipes.show');
        Route::get('/edit', [MyrecipeController::class, 'edit'])->name('myrecipes.edit');
        Route::post('/edit', [MyrecipeController::class, 'edit'])->name('myrecipes.edit');
        Route::post('/update', [MyrecipeController::class, 'update']);
        Route::post('/delete', [MyrecipeController::class, 'delete']);
        Route::get('/{value}', [MyrecipeController::class, 'index'])->name('myrecipes.myrecipe');
    });

    Route::group(['prefix' => '/posts'], function() {
        Route::get('/confirm', [PostController::class, 'confirm'])->name('posts.confirm');
        Route::post('/confirm', [PostController::class, 'confirm'])->name('posts.confirm');
        Route::post('/add', [PostController::class, 'add']);
        Route::post('/delete', [PostController::class, 'delete']);
        Route::get('/bookmark/order', [PostController::class, 'showBookmarkOrder'])->name('posts.order');
        // Route::get('/access/order', [PostController::class, 'showAccessOrder']);
        Route::get('/{value}', [PostController::class, 'index'])->name('posts.post');
    });

    Route::post('/bookmarks/bookmark', [BookmarkController::class, 'bookmark']);
    Route::get('/reports/form', [ReportController::class, 'showform'])->name('reports.form');
    Route::post('/reports/form', [ReportController::class, 'showform'])->name('reports.form');
    Route::post('/reports/add', [ReportController::class, 'add']);
});
Route::get('/managements', [ManagementController::class, 'index'])->name('managements.manage');
// Route::group(['prefix' => '/managements'], function() {
//     Route::get('/post', [ManagementController::class, 'showPost']);
//     Route::post('/post', [ManagementController::class, 'searchPost']);
//     Route::post('/post/delete', [ManagementController::class, 'deletePost']);
//     Route::post('/post/update', [ManagementController::class, 'updatePost']);
//     Route::post('/report', [ManagementController::class, 'showReport']);
//     Route::post('/report/delete', [ManagementController::class, 'deleteReport']);
//     Route::post('/report/update', [ManagementController::class, 'updateReport']);
// });

Route::get('/register', [AuthController::class,'getRegister']);
Route::post('/register', [AuthController::class,'postRegister']);

Route::get('/login', [AuthController::class,'getLogin'])->name('login');;
Route::post('/login', [AuthController::class,'postLogin']);

// require __DIR__.'/auth.php';
