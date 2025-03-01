<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    //
    use HasFactory;

    protected $fillable = ['image', 'author', 'description', 'category'];

    public function votes()
    {
        return $this->hasMany(Votes::class);
    }
}
