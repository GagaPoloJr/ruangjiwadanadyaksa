<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::post('/git-webhook', function () {
    try {
        $output = shell_exec('cd /home/ruat9133/repositories/ruangjiwadanadyaksa && git pull origin main && composer install --no-dev --prefer-dist && php artisan migrate --force 2>&1');

        Log::info('Git Deploy Output:', [$output]);

        return response()->json(['message' => 'Repository updated!', 'output' => $output]);
    } catch (\Exception $e) {
        Log::error('Git Webhook Error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to update repository'], 500);
    }
});



Route::get('/', [FrontController::class, 'index'])->name('vote.index');
Route::post('/vote', [FrontController::class, 'vote'])->name('vote.store');
Route::get('/artworks/{artwork:slug}', [FrontController::class, 'show'])->name('artworks.show');

Route::post('/artworks/{artwork:slug}/comments', [CommentController::class, 'store'])->name('comments.store');