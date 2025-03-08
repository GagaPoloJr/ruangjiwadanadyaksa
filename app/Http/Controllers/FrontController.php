<?php


namespace App\Http\Controllers;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Votes;
use App\Models\Artwork;
use App\Models\CategoryVote;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $categories = CategoryVote::all();
        $artworks = Artwork::paginate(6);
        $votingDeadline = Setting::get('voting_deadline', now()->addDays(3)->toDateTimeString());
        $seo['meta_title'] = Setting::get('seo_title', 'Default Title');
        $seo['meta_desc'] = Setting::get('seo_description', 'Default Description');

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


        if ($request->ajax()) {
            return view('homepage.artwork-list', compact('artworks'))->render();
        }


        return view('vote.index', compact('categories', 'artworks', 'steps', 'seo', 'votingDeadline'));
    }
    public function loadMoreArtworks(Request $request)
{
    $artworks = Artwork::paginate(6);

    return view('homepage.artwork-list', compact('artworks'))->render();
}


    public function vote(Request $request)
    {
        $request->validate([
            'artwork_id' => 'required|exists:artworks,id',
            'category_id' => 'required|exists:category_votes,id',
        ]);

        $votingDeadline = Setting::get('voting_deadline', now()->addDays(3)->toDateTimeString());
        $votingDeadline = Carbon::parse($votingDeadline);

        // Check if voting period has expired
        if (now()->greaterThan($votingDeadline)) {
            return back()->with('error', 'Voting telah ditutup. Anda tidak dapat melakukan voting.');
        }

        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        // Cek apakah sudah pernah voting sebelumnya
        $existingVote = Votes::where('artwork_id', $request->artwork_id)
            ->where('ip_address', $ipAddress)
            ->first();

        if ($existingVote) {
            return back()->with('error', 'Anda sudah voting untuk karya ini.');
        }

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
        $categories = CategoryVote::all();
        $votingDeadline = Setting::get('voting_deadline', now()->addDays(3)->toDateTimeString());

        $artwork->load([
            'comments' => function ($query) {
                $query->latest();
            }
        ]);

        return view('artworks.detail', compact('artwork', 'categories', 'votingDeadline'));
    }

}
