<?php

use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\LoginController;
use App\Http\Controllers\V1\NoteController;
use App\Http\Controllers\V1\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::resources([
        'profile' => ProfileController::class,
        'note' => NoteController::class,
        'category' => CategoryController::class
    ]);

    Route::get('profile/{id}/note/{noteId}/categories/{categoryId}', [CategoryController::class, 'index']);
    Route::delete('profile/{id}/note/{noteId}/categories/{categoryId}', [CategoryController::class, 'destroy']);
    Route::post('profile/{id}/note/{noteId}/categories/{categoryId}', [CategoryController::class, 'update']);

});

Route::group(['prefix' => '/user'], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});
