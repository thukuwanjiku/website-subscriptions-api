<?php

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

/*
 * Routes for websites
 * */
Route::post("/websites/create", [\App\Http\Controllers\WebsitesController::class, 'create']);
Route::get("/websites", [\App\Http\Controllers\WebsitesController::class, 'index']);
Route::post("/websites/new-subscriber", [\App\Http\Controllers\WebsitesController::class, 'newSubscriber']);


/*
 * Routes for Posts
 * */
Route::post("/posts/create", [\App\Http\Controllers\PostsController::class, 'create']);
Route::get("/posts", [\App\Http\Controllers\PostsController::class, 'index']);

/*
 * Routes for Users
 * */
Route::post("/users/create", [\App\Http\Controllers\UsersController::class, 'create']);
Route::get("/users", [\App\Http\Controllers\UsersController::class, 'index']);