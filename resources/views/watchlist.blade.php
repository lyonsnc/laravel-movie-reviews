@extends('layouts.app')

@section('title', auth()->user()->username . "'s Watchlist")

@section('content')


<div class="watchlist-title-container">
    <h1>{{ auth()->user()->username }}'s Watchlist</h2>
    <div class="watchlist-title-bottom">
        <p class="no-movies">{{ count($watchlist) }} Movies</p>
        <a class="watchlist-button-search" href="{{ route('movies.search') }}"><span class="search-icon">⌕</span> Add Movies</a>
    </div>
</div>

<hr class="watchlist-break">

<div class="watchlist-display">
    @foreach($watchlist as $item)
        <div class="watchlist-movie">
            @if (!empty($item->movie->poster))
                <img class="movie-thumbnail" src="https://image.tmdb.org/t/p/w500{{ $item->movie->poster }}"
                alt="{{ $item->movie->title }} poster"
                >
            @else
                <div class="movie-thumbnail"><img class="fix-question" src="{{ asset('missing_poster.png') }}" alt="missing"></div>
            @endif
            <div class="watchlist-header">
                <div class="clickable-title">
                    <h2>
                    <a href="{{ route('movies.show', $item->movie->external_id) }}">
                    {{ $item->movie->title }}</a>
                    </h2>
                </div>
            
                <div class="year-dir">
                    <span class="year">{{ $item->movie->year }}</span>
                    <span class="dir">•  Dir. {{ $item->movie->director }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('watchlist.destroy', $item->movie) }}" class="mod-watchlist-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="del-watchlist">🗑</button>
            </form>
        </div>
    @endforeach
</div>


@endsection
