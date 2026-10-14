<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'external_id',
        'title',
        'year',
        'director',
        'poster',
    ];

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function watchlists() {
        return $this->hasMany(Watchlist::class);
    }
}
