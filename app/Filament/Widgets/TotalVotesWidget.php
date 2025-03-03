<?php

namespace App\Filament\Widgets;

use App\Models\CategoryVote;
use App\Models\Votes;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class TotalVotesWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return CategoryVote::all()->map(function ($category) {
            return Card::make($category->name, Votes::where('category_id', $category->id)->count());
        })->toArray();
    }
}
