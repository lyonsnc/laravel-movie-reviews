<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;

class MovieController extends Controller
{
    public function search(Request $request) {
        $results = [];

        #handle case of search bar
        if ($request->has('query')) {
            $query = $request->query('query');
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get('https://api.themoviedb.org/3/search/movie', [
                    'query' => $query,
            ]);
            $results = $response->json('results', []);
        }
        #whatever the results are, return it
        return view('movies/movie_search', [
            'results' => $results,
        ]);
    }
    #display individual movie page
    public function show($movie) {
        #grab movie details
        $movieResponse = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/movie/{$movie}");
        $movieData = $movieResponse->json();

        #pull credits as well
        $creditsResponse = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/movie/{$movie}/credits");
        $credits = $creditsResponse->json();

        #find director
        $director = 'unknown';
        foreach ($credits['crew'] ?? [] as $person) {

            if ($person['job'] === 'Director') {
                $director = $person['name'];
                break;
            }

        }
        #pull top five cast, year
        $cast = array_slice($credits['cast'] ?? [], 0, 5);
        $year = ($movieData['release_date']) ? substr($movieData['release_date'], 0, 4) : 'unknown';
        #pull local data - blazing fast!
        $local_movie = Movie::where('external_id', $movie)->first();
        #create if not local
        if (!$local_movie) {
            $local_movie = Movie::create([
                'external_id' => $movie,
                'title' => $movieData['title'],
                'year' => $year,
                'director' => $director,
                'poster' => $movieData['poster_path'] ?? null,
            ]);
        }
        $local_reviews = $local_movie->reviews()
            ->with('user')
            ->latest('created_at')
            ->get();
        $average_rating = $local_reviews->count() > 0 ? $local_reviews->avg('rating') : null;
        $average_rating = round($average_rating, 2);
        $watchlisted = auth()->check()
        && $local_movie->watchlists()
        ->where('user_id', auth()->id())
        ->exists();
        #return it all
        return view('movies/movie', [
            'movie' => $movieData,
            'director' => $director,
            'cast' => $cast,
            'year' => $year,
            'local_movie' => $local_movie,
            'local_reviews' => $local_reviews,
            'average_rating' => $average_rating,
            'watchlisted' => $watchlisted,
        ]);
    }
}
