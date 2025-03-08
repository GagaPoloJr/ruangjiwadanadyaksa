<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArtworkSeeder extends Seeder
{
    public function run()
    {
        $categories = ['goresan', 'ekspresi', 'larik'];
        $artworks = [];

        for ($i = 1; $i <= 20; $i++) {
            $title = 'Artwork ' . $i;
            $artworks[] = [
                'title' => $title,
                'slug' => Str::slug($title),
                'image' => 'artwork_' . $i . '.jpg',
                'author' => 'Author ' . $i,
                'description' => Str::random(50),
                'category' => $categories[array_rand($categories)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('artworks')->insert($artworks);
    }
}
