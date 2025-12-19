 <?php

use App\Http\Controllers\contactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\postController;
use App\Http\Controllers\schoolController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Posts route (public - to display all posts)
Route::get('/post', [postController::class, 'showPosts'])->name('posts');
// Post routes (protected)
Route::get('/message', [postController::class, 'message'])->middleware('auth')->name('message');
Route::post('/create_posts', [postController::class, 'createPost'])->middleware('auth')->name('create_posts');
Route::get('/search', [postController::class, 'search'])->middleware('auth')->name('search');
Route::get('/drafts', [postController::class, 'showDrafts'])->middleware('auth')->name('drafts.index');

// Authentication routes
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('edit/{post}', [postController::class, 'edit']);
Route::put('edit/{post}', [postController::class, 'update']);
Route::delete('delete/{post}', [postController::class, 'destroy']);
Route::get('drafts/{post}', [postController::class, 'draft'])->name('drafts.edit');

// Contact form route
Route::post('/contact', [contactController::class, 'submitContactForm']);
Route::get('/contact', [contactController::class, 'displayContactMessage']);

// Schools routes
Route::get('/schools', [schoolController::class, 'index'])->name('schools.index');
Route::post('/schools', [schoolController::class, 'uploadSchools'])->name('schools.upload');
Route::post('/schools/store', [schoolController::class, 'store'])->name('schools.store');
