<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;

Route::post('/createUser', [UserController::class, 'createUser']);
Route::post('/createProduct', [ProductController::class, 'createProduct']);
Route::post('/createReview', [ReviewController::class, 'createReview']);
