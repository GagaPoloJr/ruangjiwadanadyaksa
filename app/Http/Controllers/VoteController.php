<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Votes;
use App\Models\Artwork;

class VoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'artwork_id' => 'required|exists:artworks,id',
            'category_id' => 'required|exists:category_votes,id',
        ]);

        $ipAddress = $request->ip();

        // Cek apakah IP sudah voting untuk kategori ini
        $existingVote = Votes::where('ip_address', $ipAddress)
            ->where('category_id', $request->category_id)
            ->first();

        if ($existingVote) {
            return response()->json(['message' => 'Anda sudah voting di kategori ini!'], 400);
        }

        // Simpan vote baru
        Votes::create([
            'artwork_id' => $request->artwork_id,
            'category_id' => $request->category_id,
            'ip_address' => $ipAddress,
        ]);

        return response()->json(['message' => 'Vote berhasil!'], 201);
    }
}
