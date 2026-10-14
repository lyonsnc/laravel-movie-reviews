@extends('layouts.app')

@section('title', auth()->user()->username)

@section('content')
<div class="profile-header">
    <div class="profile-header-ab">
    <h1>{{ auth()->user()->username }}</h1>
    <small>First Review: {{ $earliest_date }}</small>
    </div>
    <br>
    <div class="profile-header-sub">
        <h2>Movies Watched: {{ count($reviews) }}</h2>
        <a href="{{ route('watchlist') }}" class="profile-watchlist">≡ Watchlist</a>
    </div>
</div>
<hr>
<a href="{{route('movies.search')}}" class="review-button">
    <span>+</span>
</a>
@if ($reviews)
<h2 class="profile-reviews-title">Reviews</h2>
<div class="profile-reviews-container">
    @foreach ($reviews as $review)

            <article class="review">
            @if (!empty($review->movie->poster))
                <img class="index-review-poster" src="https://image.tmdb.org/t/p/w500{{ $review->movie->poster }}"
                alt="{{ $review->movie->title }} poster"
                >
            @else
                <img class="index-review-poster" src="{{ asset('missing_poster.png') }}" alt="missing">
            @endif
            <div class="index-header">
                <div class="index-header-text">
                <div class="clickable-title">
                    <h2>
                    <a href="{{ route('movies.show', $review->movie->external_id) }}">
                    {{ $review->movie->title }}</a>
                    </h2>
                </div>
            
                <div class="year-dir">
                    <span class="year">{{ $review->movie->year }}</span>
                    <span class="dir">•  Dir. {{ $review->movie->director }}</span>
                </div>

                <p>
                    Rating:
                    {{$review->rating}}/5
                </p>
                </div>
            </div>

            <p>
                {{$review->review}}
            </p>

            <small>
                {{ substr($review->created_at, 0, 10) }}
            </small>
        </article>
        

    @endforeach
</div>
@endif
@endsection