<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Watchlist;
use App\Models\Movie;

class WatchlistController extends Controller
{
    #display user watchlist
    public function index() {
        $watchlist = Watchlist::with('movie')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('watchlist', [
            'watchlist' => $watchlist
        ]);
    }
    #add to watchlist
    public function store(Movie $movie) {
        Watchlist::firstOrCreate([
            'user_id' => auth()->id(),
            'movie_id' => $movie->id,
        ]);
        return back()->with('message', 'Movie added to Watchlist!');
    }
    #remove from watchlist
    public function destroy(Movie $movie) {
        Watchlist::where('user_id', auth()->id())
            ->where('movie_id', $movie->id)
            ->delete();
        return back()->with('message', 'Movie removed from watchlist');
    }

}
