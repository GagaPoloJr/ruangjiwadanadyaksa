<?php

namespace App\Filament\Widgets;

use App\Models\Artwork;
use App\Models\CategoryVote;
use App\Models\Votes;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
class TopVotesWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $totalVotes = Votes::count(); // total semua votes

        $categoryVotes = CategoryVote::all()->map(function ($category) {
            // Cari artwork dengan vote terbanyak dalam kategori ini
            $topArtwork = Artwork::whereHas('votes', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
                ->withCount([
                    'votes' => function ($query) use ($category) {
                        $query->where('category_id', $category->id);
                    }
                ])
                ->orderByDesc('votes_count')
                ->first();

            $topArtworkTitle = $topArtwork ? $topArtwork->title . " ({$topArtwork->votes_count} votes)" : 'No votes yet';
            return Card::make(
                "Kategori: {$category->name}",
                $topArtworkTitle
            );
        });

        return array_merge([
            Card::make('Total Votes', $totalVotes),
        ], $categoryVotes->toArray());
    }
}
