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
use App\Http\Controllers\V1\UserController;
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
    Route::get('game/{id}', [GameController::class, 'show'])->name('games.show');
    Route::get('game/{id}/reviews', [GameController::class, 'getReviewInfo'])->name('games.review.info');

    Route::get('games/{status}', [GameController::class, 'getGamesByStatus'])->name('games.status');
    Route::get('games/search', [GameController::class, 'search'])->name('games.search');
    Route::get('games/popular', [GameController::class, 'showPopular'])->name('games.popular');

    Route::post('game/{gameId}/status', [GameStatusController::class, 'update'])->name('status.update');

    Route::post('lists/{list}/items', [ListItemController::class, 'create']);
    Route::post('lists/{list}/items/{item}', [ListItemController::class, 'destroy']);

    Route::get('deal/search', [DealController::class, 'show'])->name('deals.show');

    Route::resource('lists', GameListController::class)->only([
        'index', 'store', 'show', 'update', 'destroy',
    ]);

    Route::resource('reviews', ReviewController::class)->only([
        'index', 'store', 'show', 'update', 'destroy',
    ]);

    Route::resource('activities', ActivityController::class)->only([
        'index', 'show', 'destroy'
    ]);
    Route::get('user/activities/{userId}', [ActivityController::class, 'getUserActivity']);

    Route::get('user/followers', [FollowerController::class, 'index'])->name('followers.index');
    Route::post('user/follow/{userId}', [FollowerController::class, 'follow'])->name('followers.follow');
    Route::delete('user/follow/{userId}', [FollowerController::class, 'unfollow'])->name('followers.unfollow');
    Route::get('user/news-feed', [FollowerController::class, 'getNewsFeed'])->name('user.news-feed');
    Route::get('user/search', [UserController::class, 'search'])->name('user.search');

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
