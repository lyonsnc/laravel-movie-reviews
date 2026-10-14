<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReviewController extends Controller
{
    public function index() {
        $reviews = Review::with(['user', 'movie'])
            ->latest()
            ->paginate(5);
        return view('index', [
            'reviews' => $reviews
        ]);
    }

    #function for adding reviews
    public function add() {
        $apiExternal = request('exmovie_id');

        if (!$apiExternal) {
            return redirect()->route('movies.search');
        }

        $movieResponse = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/movie/{$apiExternal}");
        $movie = $movieResponse->json();

        $creditsResponse = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/movie/{$apiExternal}/credits");

        $credits = $creditsResponse->json();

        $director = 'unknown';
        foreach ($credits['crew'] ?? [] as $person) {
            if ($person['job'] === 'Director') {
                $director = $person['name'];
                break;
            }
        }

        $year = ($movie['release_date']) ? substr($movie['release_date'], 0, 4) : 'unknown';
        
        return view('reviews.create', [
            'movie' => $movie,
            'director' => $director,
            'year' => $year,
            'apiExternal' => $apiExternal,
        ]);
    }

    #store review in local database
    public function store(Request $request) {
        $validated = $request->validate([
            'api_id' => 'required|integer',
            'title' => 'required|string',
            'year' => 'nullable|integer',
            'director' => 'nullable|string',
            'poster' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:5',
            'review' => 'required|string',
        ]);
        //check for local existence in database
        $local_movie = Movie::where('external_id', $validated['api_id'])->first();
        //if not local, insert first
        if (!$local_movie) {
            $local_movie = Movie::create([
                'external_id' => $validated['api_id'],
                'title' => $validated['title'],
                'year' => $validated['year'],
                'director' => $validated['director'],
                'poster' => $validated['poster'],
            ]);
        }

        //create review with local_movie id and request review contents
        Review::create([
            'user_id' => auth()->id(),
            'movie_id' => $local_movie->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);
        return redirect()->route('home')->with('success', 'Review added!');
    }
}
