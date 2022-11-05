<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use const App\Helpers\ALLOWED_THIRD_PARTY;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request)
{
    return $request->user();
});

Route::group(['middleware' => ['default.headers'], 'as' => 'admin'], function ()
{
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['default.headers', 'auth:sanctum']], function ()
{
//    Route::apiResource('posts', PostController::class);
});
