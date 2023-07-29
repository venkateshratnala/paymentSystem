<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaypalController;


Route::get('/', [LoginController::class, 'LoginredirectPage'])->middleware('guest:web');
Route::get('/login/{return_url?}', [LoginController::class, 'loginPage'])->name('login')->middleware('guest:web');
Route::post('/doLogin', [LoginController::class, 'postLogin'])->name('doLogin')->middleware('guest:web');
Route::get('/signup', [LoginController::class, 'signupPage'])->name('signup')->middleware('guest:web');
Route::post('/doSignUp', [LoginController::class, 'doSignUp'])->name('doSignUp')->middleware('guest:web');


Route::get('/profile', [ProfileController::class, 'profile'])->name('profile')->middleware('auth:web');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth:web');


Route::get('/products', [ProductController::class, 'products'])->name('products');
Route::post('/initiate_subscription', [ProductController::class, 'initiate_subscription'])->name('initiate_subscription');
Route::get('/payment', [PaymentController::class, 'index']);

//product
Route::get('/create_product', [ProductController::class, 'create_product'])->name('create_product');
Route::get('/fetch_product', [ProductController::class, 'fetch_product'])->name('fetch_product');

//plan
Route::get('/fetch_plan', [PaypalController::class, 'fetch_plan'])->name('fetch_plan');
Route::get('/create_plan', [PaypalController::class, 'create_plan'])->name('create_plan');
Route::get('/payment', [PaymentController::class, 'payment'])->middleware('auth:web');
