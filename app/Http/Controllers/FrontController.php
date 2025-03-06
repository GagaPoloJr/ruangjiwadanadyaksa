<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Votes;
use App\Models\Artwork;
use App\Models\CategoryVote;

class FrontController extends Controller
{
    public function index()
    {
        $categories = CategoryVote::all();
        $artworks = Artwork::all();

        $steps = [
            [
                'number' => 1,
                'title' => 'Pilih Karya Seni',
                'description' => 'Pilih karya seni yang kamu suka dari daftar karya seni yang tersedia.',
            ],
            [
                'number' => 2,
                'title' => 'Klik Tombol Vote',
                'description' => 'Tekan tombol vote untuk memberikan suara pada karya seni favoritmu.',
            ],
            [
                'number' => 3,
                'title' => 'Pilih Kategori',
                'description' => 'Pilih kategori voting yang kamu inginkan.',
            ],
            [
                'number' => 4,
                'title' => 'Selesai',
                'description' => 'Voting kamu telah berhasil! Karya seni dengan suara terbanyak akan memenangkan kompetisi.',
            ],
        ];


        return view('vote.index', compact('categories', 'artworks', 'steps'));
    }

    public function vote(Request $request)
    {
        $request->validate([
            'artwork_id' => 'required|exists:artworks,id',
            'category_id' => 'required|exists:category_votes,id',
        ]);

        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        // Cek apakah sudah pernah voting sebelumnya
        $existingVote = Votes::where('artwork_id', $request->artwork_id)
            ->where('ip_address', $ipAddress)
            ->first();

        if ($existingVote) {
            return back()->with('error', 'Anda sudah voting untuk artwork ini dalam kategori ini.');
        }

        // Simpan vote baru
        Votes::create([
            'artwork_id' => $request->artwork_id,
            'category_id' => $request->category_id,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);

        return back()->with('success', 'Vote berhasil ditambahkan!');
    }

    public function show(Artwork $artwork)
    {
        // Load comments dengan urutan terbaru
        $artwork->load([
            'comments' => function ($query) {
                $query->latest();
            }
        ]);

        return view('artworks.detail', compact('artwork'));
    }

}
