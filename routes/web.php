<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [LoginController::class, 'LoginredirectPage'])->middleware('guest:web');
Route::get('/login', [LoginController::class, 'loginPage'])->name('login')->middleware('guest:web');
Route::post('/doLogin', [LoginController::class, 'postLogin'])->name('doLogin')->middleware('guest:web');
Route::get('/signup', [LoginController::class, 'signupPage'])->name('signup')->middleware('guest:web');
Route::post('/doSignUp', [LoginController::class, 'doSignUp'])->name('doSignUp')->middleware('guest:web');

Route::get('/profile', [ProfileController::class, 'profile'])->name('profile')->middleware('auth:web');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth:web');


Route::get('/payment', [PaymentController::class, 'index']);


