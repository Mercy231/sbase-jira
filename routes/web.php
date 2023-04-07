<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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
    })->name('login');
    Route::post('/login', [UserController::class, 'login']);
});
Route::get('/logout', function () {
    Auth::logout();
    return redirect('home');
});
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/email/verification-notification', function () {
    Auth::user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/home', function () {
    return view('home');
});
Route::get('/', function () {
    return redirect('home');
});
