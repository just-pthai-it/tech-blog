<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => ['default.headers']], function ()
{
    Route::post('login/{third_party?}', [AuthController::class, 'login'])->name('login')
         ->where(['third_party' => implode('|', ALLOWED_THIRD_PARTY)]);
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::group(['middleware' => ['default.headers']], function ()
{
    Route::middleware(['auth:sanctum'])->group(function ()
    {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('logout/all', [AuthController::class, 'logoutAll'])->name('logout_all');
    });

    Route::get('me', [UserController::class, 'show'])->name('me');

    Route::apiResource('posts', PostController::class);
    Route::apiResource('users', UserController::class);
});
