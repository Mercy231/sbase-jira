<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAuth;
use App\Http\Middleware\LanguageManager;
use App\Http\Middleware\LastSeenUserActivity;
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
    Route::get('/register', [UserController::class, 'index']);
    Route::post('/register/getStates', [UserController::class, 'getStates']);
    Route::post('/register/getCities', [UserController::class, 'getCities']);
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

Route::middleware('auth')
    ->middleware(LanguageManager::class)
    ->middleware(LastSeenUserActivity::class)
    ->group(function () {
    Route::get('/posts', [PostController::class, 'showPosts'])
        ->name('posts');

    Route::post('/post/create', [PostController::class, 'create']);
    Route::patch('/post/{id}', [PostController::class, 'update']);
    Route::delete('/post/{id}', [PostController::class, 'destroy']);

    Route::post('/comment/create', [CommentController::class, 'create']);
    Route::patch('/comment/{id}', [CommentController::class, 'update']);
    Route::delete('/comment/{id}', [CommentController::class, 'destroy']);

    Route::post('/reply/create', [CommentController::class, 'create']);

    Route::get('/autoria', [ScraperController::class, 'index']);
    Route::post('/autoria', [ScraperController::class, 'search']);

    Route::post("/changeLang", [UserController::class, "changeLang"]);

    Route::get('/parseXML', [UserController::class, 'parseXML']);

    Route::get('/admin/stats', [AdminController::class, 'index']);
    Route::get('/admin/get/stats', [AdminController::class, 'stats']);
});

Route::get('/home', function () {
    return view('home');
});
Route::get('/', function () {
    return redirect('home');
});
