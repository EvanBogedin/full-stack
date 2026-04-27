<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/createUser', [UserController::class, 'createUser']);
Route::post('/createProduct', [ProductController::class, 'createProduct']);
Route::post('/createReview', [ReviewController::class, 'createReview']);

Route::match(['get', 'post'], '/search', [ProductController::class, 'search']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/getReviews', [ReviewController::class, 'getReviews']);
Route::post('/getProductById', [ProductController::class, 'getProductById']);
Route::get('/getAllProducts', [ProductController::class, 'getAllProducts']);

Route::put('/updateReviewLikes', [ReviewController::class, 'updateReviewLikes']);
Route::put('/updateReviewDislikes', [ReviewController::class, 'updateReviewDislikes']);
Route::put('/updateProduct', [ProductController::class, 'updateProduct']);

Route::delete('/deleteProduct/{id}', [ProductController::class, 'deleteProduct']);
Route::delete('/deleteReview/{id}', [ReviewController::class, 'deleteReview']);
Route::delete('/deleteUser/{id}', [UserController::class, 'deleteUser']);
