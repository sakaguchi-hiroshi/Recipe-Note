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

Route::get('/', [RecipeNoteController::class, 'index']);

Route::get('/services/premium', [RecipeNoteController::class, 'showPremiumService']);

Route::middleware('auth')->group(function() {
    Route::get('/logout', [AuthController::class,'getLogout']);

    Route::group(['prefix' => '/myrecipes'], function() {
        Route::get('/form', [MyrecipeController::class, 'showForm'])->name('myrecipes.form');
        Route::post('/add', [MyrecipeController::class, 'add'])->name('myrecipes.myrecipe');
        Route::get('/show', [MyrecipeController::class, 'show'])->name('myrecipes.show');
        // Route::post('/delete', [MyrecipeController::class, 'delete']);
        // Route::post('/update', [MyrecipeController::class, 'update']);
        Route::get('/{value}', [MyrecipeController::class, 'index'])->name('myrecipes.myrecipe');
    });
});
// Route::group(['prefix' => '/posts'], function() {
//     Route::get('', [PostController::class, 'index']);
//     Route::get('/form', [PostController::class, 'showForm']);
//     Route::post('/form', [PostController::class, 'send']);
//     Route::post('/add', [PostController::class, 'add']);
//     Route::post('/delete', [PostController::class, 'delete']);
//     Route::post('/update', [PostController::class, 'update']);
//     Route::get('/recipe', [PostController::class, 'showPostRecipe']);
//     Route::get('/movie', [PostController::class, 'showPostMovie']);
//     Route::get('/report/order', [PostController::class, 'showReportOrder']);
//     Route::get('/access/order', [PostController::class, 'showAccessOrder']);
// });
// Rout::group(['prefix' => '/bookmarks'], function() {
//     Route::get('', [BookmarkController::class, 'index']);
//     Route::get('/show', [BookmarkController::class, 'show']);
//     Route::post('/add', [BookmarkController::class, 'add']);
//     Route::post('/delete', [BookmarkController::class, 'delete']);
// });
// Route::group(['prefix' => '/reports'], function() {
//     Route::get('', [ReportController::class, 'showForm']);
//     Route::post('', [ReportController::class, 'send']);
//     Route::post('/add', [ReportController::class, 'add']);
//     Route::post('/delete', [ReportController::class, 'delete']);
//     Route::post('/update', [ReportController::class, 'update']);
// });
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
