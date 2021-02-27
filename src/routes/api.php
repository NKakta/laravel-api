<?php

use App\Http\Controllers\V1\GameController;
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
    Route::get('games/search', [GameController::class, 'search']);
    Route::get('game/{id}', [GameController::class, 'show']);

    Route::post('game/{gameId}/status', [GameStatusController::class, 'update']);
});

Route::group(['prefix' => '/user'], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact nedas'], 404);
});
