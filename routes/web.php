<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::post('/git-webhook', function () {
//     try {
//         $output = shell_exec('cd /home/ruat9133/repositories/ruangjiwadanadyaksa && git pull origin main && composer install --no-dev --prefer-dist && php artisan migrate --force 2>&1');

//         Log::info('Git Deploy Output:', [$output]);

//         return response()->json(['message' => 'Repository updated!', 'output' => $output]);
//     } catch (\Exception $e) {
//         Log::error('Git Webhook Error: ' . $e->getMessage());
//         return response()->json(['error' => 'Failed to update repository'], 500);
//     }
// });

Route::get('/run-dump-autoload', function (Request $request) {
  
    Artisan::call('dump-autoload');
    return response()->json(['message' => 'Composer dump-autoload executed']);
});

Route::post('/git-webhook', function () {
    try {
        // Jalankan perintah Git Pull
        $output = shell_exec('cd /home/ruat9133/repositories/ruangjiwadanadyaksa && git pull origin main 2>&1');

        // Jalankan Composer Install (tanpa dev dependencies)
        // $composerOutput = shell_exec('cd /home/ruat9133/repositories/ruangjiwadanadyaksa && composer install --no-dev --prefer-dist 2>&1');

        // Generate Key
        // Artisan::call('key:generate');
        // $keyOutput = Artisan::output();

        // // Jalankan migrate dengan force
        // Artisan::call('migrate', ['--force' => true]);
        // $migrateOutput = Artisan::output();

        // Log output ke Laravel log
        Log::info('Git Deploy Output:', [
            'git' => $output,
            // 'composer' => $composerOutput,
            // 'key_generate' => $keyOutput,
            // 'migrate' => $migrateOutput
        ]);

        return Response::json([
            'message' => 'Repository updated!',
            'git_output' => $output,
            // 'composer_output' => $composerOutput,
            // 'key_generate_output' => $keyOutput,
            // 'migrate_output' => $migrateOutput
        ]);
    } catch (\Exception $e) {
        Log::error('Git Webhook Error: ' . $e->getMessage());
        return Response::json(['error' => 'Failed to update repository'], 500);
    }
});



Route::get('/', [FrontController::class, 'index'])->name('vote.index');
Route::post('/vote', [FrontController::class, 'vote'])->name('vote.store');
Route::get('/artworks/{artwork:slug}', [FrontController::class, 'show'])->name('artworks.show');

Route::post('/artworks/{artwork:slug}/comments', [CommentController::class, 'store'])->name('comments.store');