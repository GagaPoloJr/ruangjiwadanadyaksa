<?php

if (!function_exists('getCategoryLabel')) {
    function getCategoryLabel($category)
    {
        $labels = [
            'goresan' => 'Goresan Perasaan',
            'ekspresi' => 'Lukisan Ekspresi',
            'larik' => 'Larik Bermakna',
        ];

        return $labels[$category] ?? $category;
    }
}