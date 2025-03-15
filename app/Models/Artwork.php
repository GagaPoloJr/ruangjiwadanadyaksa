<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;
use Illuminate\Database\Eloquent\SoftDeletes;
class Artwork extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'image', 'author', 'description', 'category', 'slug', 'featured_description'];
    protected $dates = ['deleted_at'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($artwork) {
            $artwork->slug = Str::slug($artwork->title);
        });

        static::updating(function ($artwork) {
            $artwork->slug = Str::slug($artwork->title);
        });

        static::saving(function ($artwork) {
            $artwork->featured_description = Str::limit(strip_tags($artwork->description), 200);
        });
    }

    public function getCategoryLabelAttribute()
    {
        $labels = [
            'goresan' => 'Goresan Perasaan',
            'ekspresi' => 'Lukisan Ekspresi',
            'larik' => 'Larik Bermakna',
        ];

        return $labels[$this->category] ?? $this->category;
    }



    public function votes()
    {
        return $this->hasMany(Votes::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function totalVotes()
    {
        return $this->votes->count();
    }
}
