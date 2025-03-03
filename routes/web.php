<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [FrontController::class, 'index'])->name('vote.index');
Route::post('/vote', [FrontController::class, 'vote'])->name('vote.store');
Route::get('/artworks/{artwork:slug}', [FrontController::class, 'show'])->name('artworks.show');

Route::post('/artworks/{artwork:slug}/comments', [CommentController::class, 'store'])->name('comments.store');