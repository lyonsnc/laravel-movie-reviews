@extends('layouts.app')

@section('title', 'Archive Search')

@section('content')
<h1>Search the Archive</h1>

<form method="GET">

    <input
        type="text"
        name="query"
        placeholder="search by title..."
        required
    >

    <button type="submit">Go!</button>
</form>

@foreach ($results as $movie)
    <article class="movie-search">
        
        <div class="movie-info">
            <div class="clickable-title">
                <h2>
                    <a href="{{ route('movies.show', $movie['id']) }}">
                    {{ $movie['title'] }}</a>
                </h2>
            </div>

            <p>
            {{ substr($movie["release_date"] ?? "", 0, 4) }}
            </p>
        

        <form method="GET" action="{{ route('reviews.add') }}">
            <input
                type="hidden"
                name="exmovie_id"
                value="{{ $movie['id'] }}"
            >
            <button type="submit">add a review</button>
        </form></div>

        @if (!empty($movie["poster_path"]))
            <img class="movie-poster" src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                alt="{{ $movie['title'] }} poster"
            >
        @endif

    </article>
@endforeach

@endsection