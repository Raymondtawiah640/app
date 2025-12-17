<?php

use App\Http\Controllers\contactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\postController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Posts route (public - to display all posts)
Route::get('/post', [postController::class, 'showPosts'])->name('posts');

// Post routes (protected)
Route::get('/message', [postController::class, 'message'])->middleware('auth')->name('message');
Route::post('/create_posts', [postController::class, 'createPost'])->middleware('auth')->name('create_posts');

// Authentication routes
Route::get('/register', [UserController::class, 'showRegister']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'showLogin']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

Route::get('edit/{post}', [postController::class, 'edit']);
Route::put('edit/{post}', [postController::class, 'update']);
Route::delete('delete/{post}', [postController::class, 'destroy']);

// Contact form route
Route::post('/contact', [contactController::class, 'submitContactForm']);
Route::get('/contact', [contactController::class, 'displayContactMessage']);
