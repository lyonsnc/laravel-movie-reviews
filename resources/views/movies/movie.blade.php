@extends('layouts.app')

@section('title', $movie['title'] . ' (' . $year . ')')

@section('content')

<main class="movie-display">
    <div class="movie-top">
    <div class="movie-big-poster">
        @if (!empty($movie["poster_path"]))
            <img class="movie-big-poster-img" src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                alt="{{ $movie['title'] }} poster"
            >
        @endif
    </div>
    <div class="movie-main-header">
        <div class="movie-main-header-top">
        <h2>{{ $movie["title"] }}</h2>
    
        <div class="movie-year-dir">
            <span class="year">{{ $year }}</span>
            <span class="dir">•  {{ $director }}</span>
        </div>
        <div class="movie-rating">
            <p>Users Rated: {{$average_rating}}</p>
        </div></div>
    
    
    <div class="movie-add-to-watchlist-button">
    @if ($watchlisted)
    <form method="POST" action="{{ route('watchlist.destroy', ['movie' => $local_movie]) }}" id="add-to-watchlist">
        @csrf
        @method('DELETE')
        <button class="add-to-watchlist-big already-added" disabled>≡ Added ✓</button>
        <button class="remove-from-watchlist" type="submit">🗑</button>
    </form>
    @else
    <form method="POST" action="{{ route('watchlist.store', $local_movie) }}" id="add-to-watchlist">
        @csrf
        <button class="add-to-watchlist-big" type="submit">≡ Add to Watchlist</button>
    </form>
    @endif
    </div>
    <div class="synopsis">
        <p>{{ !empty($movie["overview"]) ? $movie["overview"] : '(No description was found for this film)' }}</p>
    </div>
    </div></div>

    <div class="movie-cast">
        <h2>Cast</h2>
        <div class="cast-bar">
            @foreach ($cast as $person)
                <div class="cast-member">
                    <p>{{ !empty($person["name"]) ? $person["name"] : "unknown" }}</p>
                    <div class="cast-photo">
                        @if ($person["profile_path"])
                            <img src="https://image.tmdb.org/t/p/w185{{ $person['profile_path'] }}" 
                                class="cast-photo-img"
                                alt="?"
                            >
                        @else
                            <img src="{{ asset('Default_pfp.jpg') }}" class="cast-photo-img" alt="?">
                        @endif
                    </div>
                    <small> {{ !empty($person["character"]) ? 'as ' . $person["character"] : "unknown" }}</small>
                </div>
            @endforeach
        </div>
        @if (empty($cast))
            <div class="no-cast-found">
                <p>(No cast found)</p>
            </div>
        @endif
    </div>
    <div class="movies-bottom-bar">
        <div class="bottom-reviews-title">
            <h2>User Reviews</h2>
        </div>
        @if ($local_reviews->count() > 0)
            <form method="GET" action="{{ route('reviews.add') }}">
                <input
                type="hidden"
                name="exmovie_id"
                value="{{ $movie['id'] }}"
                >
                <button type="submit">Add a Review</button>
            </form>
        @endif
    </div>    
</main>

<div class="local-reviews-container">
@foreach ($local_reviews as $review)
    <div class="local-review">
    <article class="review">
        <div class="index-header">
            <p>
                Rating:
                {{ $review->rating }}/5
            </p>
        </div>

        <p>
            {{ $review->review }}
        </p>

        <small>
            {{ $review->created_at->format('Y-m-d') }}
            <span>•  {{$review->user->username }}</span>
        </small>
    </article>
    </div>
@endforeach
@if ($local_reviews->count() === 0)
    <div class="no-reviews-yet">
        <h2>No local reviews yet!</h2>
        <a href="{{ route('reviews.add', ['exmovie_id' => $movie['id']]) }}">
            <button type="button">be the first</button>
        </a>
    </div>
@endif
</div>


@endsection
