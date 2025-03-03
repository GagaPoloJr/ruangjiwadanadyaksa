<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    //
    use HasFactory;

    protected $fillable = ['artwork_id', 'category_id', 'ip_address'];

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryVote::class);
    }

}
