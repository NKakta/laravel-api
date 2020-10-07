<?php

use App\Http\Controllers\V1\CommentController;
use App\Http\Controllers\V1\PostController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::resources([
        'profile' => ProfileController::class,
        'post' => PostController::class,
        'comment' => CommentController::class
    ]);
});
