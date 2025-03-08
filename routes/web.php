<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontController::class, 'index'])->name('vote.index');
Route::get('/artworks', [FrontController::class, 'index'])->name('artworks.index');

Route::get('/load-more-artworks', [FrontController::class, 'loadMoreArtworks'])->name('artworks.loadMore');
Route::post('/vote', [FrontController::class, 'vote'])->name('vote.store');
Route::get('/artworks/{artwork:slug}', [FrontController::class, 'show'])->name('artworks.show');

Route::post('/artworks/{artwork:slug}/comments', [CommentController::class, 'store'])->name('comments.store');