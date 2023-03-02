<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeNoteController;
use App\Http\Controllers\MyrecipeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\PaymentController;

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

// Auth::routes(['verify' => true]);

Route::get('/', [RecipeNoteController::class, 'index'])->name('recipenotes.index');


Route::middleware('auth')->group(function() {
    Route::get('/logout', [AuthController::class,'getLogout']);

    Route::get('/services/premium', [RecipeNoteController::class, 'showPremiumService'])->name('recipenotes.service');
    Route::post('/pay', [PaymentController::class, 'pay']);

    Route::group(['prefix' => '/myrecipes'], function() {
        Route::get('/form', [MyrecipeController::class, 'showForm'])->name('myrecipes.form');
        Route::post('/add', [MyrecipeController::class, 'add']);
        Route::post('/image/delete', [MyrecipeController::class, 'imageDelete']);
        Route::post('/movie/delete', [MyrecipeController::class, 'movieDelete']);
        Route::get('/show', [MyrecipeController::class, 'show'])->name('myrecipes.show');
        Route::get('/edit', [MyrecipeController::class, 'edit'])->name('myrecipes.edit');
        Route::post('/edit', [MyrecipeController::class, 'edit'])->name('myrecipes.edit');
        Route::post('/update', [MyrecipeController::class, 'update']);
        Route::post('/delete', [MyrecipeController::class, 'delete']);
        Route::get('/{value}', [MyrecipeController::class, 'index'])->name('myrecipes.myrecipe');
    });

    Route::group(['prefix' => '/posts'], function() {
        Route::get('/bookmark/order', [PostController::class, 'showBookmarkOrder'])->name('posts.orders.bookmark');
        Route::get('/access/order', [PostController::class, 'showAccessOrder'])->name('posts.orders.access');
        Route::get('/confirm', [PostController::class, 'confirm'])->name('posts.confirm');
        Route::post('/confirm', [PostController::class, 'confirm'])->name('posts.confirm');
        Route::post('/add', [PostController::class, 'add']);
        Route::post('/delete', [PostController::class, 'delete']);
        Route::get('/{value}', [PostController::class, 'index'])->name('posts.post');
    });

    Route::post('/bookmarks/bookmark', [BookmarkController::class, 'bookmark']);
    Route::get('/reports/form', [ReportController::class, 'showform'])->name('reports.form');
    Route::post('/reports/add', [ReportController::class, 'add']);

    Route::group(['prefix' => '/managements'], function() {
        Route::group(['middleware' => ['auth', 'can:manager_only']], function() {
            Route::get('', [ManagementController::class, 'index'])->name('managements.manage');
            Route::post('', [ManagementController::class, 'index'])->name('managements.manage');
            Route::get('/show/user/info', [ManagementController::class, 'showUser'])->name('managements.user_info');
            Route::post('/user/delete', [ManagementController::class, 'userDelete']);
            Route::get('/show/user/post', [ManagementController::class, 'showPost'])->name('managements.user_post');
            Route::post('/user/post/delete', [ManagementController::class, 'postDelete']);
        });
    });
    // Route::middleware('verified')->group(function() {
    // });
});

Route::get('/register', [AuthController::class,'getRegister']);
Route::post('/register', [AuthController::class,'postRegister']);

Route::get('/login', [AuthController::class,'getLogin'])->name('login');;
Route::post('/login', [AuthController::class,'postLogin']);

// require __DIR__.'/auth.php';
