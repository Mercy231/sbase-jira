<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([CheckAuth::class])->group(function () {
    Route::get('/register', function () {
        return view('register', ['error' => '']);
    });
    Route::post('/register', [UserController::class, 'register']);

    Route::get('/login', function () {
        return view('login', ['error' => '']);
    });
    Route::post('/login', [UserController::class, 'login']);
});
Route::get('/logout', function () {
    Auth::logout();
    return redirect('home');
});
Route::get('/home', function () {
    return view('home');
});
Route::get('/', function () {
    return redirect('home');
});
