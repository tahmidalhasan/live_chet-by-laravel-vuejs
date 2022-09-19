<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [UserController::class, 'userLogin'])->name('user.login');
Route::post('/register', [UserController::class, 'userRegister'])->name('user.register');

Route::group(['middleware'=>'auth:api'], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile',[UserController::class, 'getUserProfile'])->name('get.user.profile');
    Route::get('/home/user/{username}',[HomeController::class, 'getUserMessage'])->name('get.user.messages');
 
    Route::post('/logout',[UserController::class, 'userLogout'])->name('get.user.logout');

});
