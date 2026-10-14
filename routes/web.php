<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;


#index
Route::get('/', [ReviewController::class, 'index'])->name('home');

#Movies

Route::get('/movies/search', [MovieController::class, 'search'])
    ->name('movies.search');

Route::get('/movies/{movie}', [MovieController::class, 'show'])
    ->name('movies.show');

#Authentication
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

#IMPORTANT - group these login-required routes
Route::middleware('auth')->group(function () {
#AddReview
Route::get('/reviews/add', [ReviewController::class, 'add'])
    ->name('reviews.add');
Route::post('/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store');

#Profile
Route::get('/profile', [ProfileController::class, 'show'])
    ->name('profile');
#Watchlist
Route::get('/watchlist', [WatchlistController::class, 'index'])
    ->name('watchlist');
Route::post('/watchlist/{movie}', [WatchlistController::class, 'store'])
    ->name('watchlist.store');
Route::delete('/watchlist/{movie}', [WatchlistController::class, 'destroy'])
    ->name('watchlist.destroy');
});