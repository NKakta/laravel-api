<?php

use App\Http\Controllers\V1\ActivityController;
use App\Http\Controllers\V1\DealController;
use App\Http\Controllers\V1\FollowerController;
use App\Http\Controllers\V1\ReviewController;
use App\Http\Controllers\V1\GameController;
use App\Http\Controllers\V1\GameListController;
use App\Http\Controllers\V1\ListItemController;
use App\Http\Controllers\V1\LoginController;
use App\Http\Controllers\V1\GameStatusController;
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
//});'middleware' => 'auth:api'

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () {
    Route::get('game/{id}', [GameController::class, 'show']);
    Route::get('game/{id}/reviews', [GameController::class, 'getReviewInfo']);

    Route::get('games/search', [GameController::class, 'search']);
    Route::get('games/popular', [GameController::class, 'showPopular']);

    Route::post('game/{gameId}/status', [GameStatusController::class, 'update']);

    Route::post('lists/{list}/items', [ListItemController::class, 'create']);
    Route::post('lists/{list}/items/{item}', [ListItemController::class, 'destroy']);

    Route::get('deal/search', [DealController::class, 'show']);

    Route::resource('lists', GameListController::class)->only([
        'index', 'store', 'show', 'update', 'destroy',
    ]);

    Route::resource('reviews', ReviewController::class)->only([
        'index', 'store', 'show', 'update', 'destroy',
    ]);

    Route::resource('activities', ActivityController::class)->only([
        'index', 'show', 'destroy'
    ]);



    Route::get('user/followers', [FollowerController::class, 'index']);
    Route::post('user/follow/{userId}', [FollowerController::class, 'follow']);
    Route::delete('user/follow/{userId}', [FollowerController::class, 'unfollow']);
    Route::get('user/news-feed', [FollowerController::class, 'getNewsFeed']);

    Route::post('/user/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::group(['prefix' => '/user'], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact nedas'], 404);
});
