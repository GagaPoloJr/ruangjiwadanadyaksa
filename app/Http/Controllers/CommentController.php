<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Artwork;
use Illuminate\Cache\RateLimiter;

class CommentController extends Controller
{
    public function store(Request $request, Artwork $artwork, RateLimiter $limiter)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        $ipAddress = $request->ip();

        // Rate limiting: maksimal 3 komentar per jam per IP
        if ($limiter->tooManyAttempts('comment-' . $ipAddress, 3)) {
            return back()->with('error', 'Anda telah mencapai batas komentar per jam.');
        }

        $limiter->hit('comment-' . $ipAddress, 3600);

        // Simpan komentar
        $artwork->comments()->create([
            'name' => $request->name,
            'comment' => $request->comment,
            'ip_address' => $ipAddress,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}