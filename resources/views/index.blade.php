@extends('layouts.app')

@section('title', 'Current Reviews')

@section('content')

    <h1>Reviews</h1>

    <a href="{{route('movies.search')}}" class="review-button">
        <span>+</span>
    </a>

    <hr>

    <main class="container">

        @foreach ($reviews as $review)

            <article class="review">

                @if (!empty($review->movie->poster))
                    <img
                        class="index-review-poster"
                        src="https://image.tmdb.org/t/p/w500{{ $review->movie->poster }}"
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
                                {{ $review->movie->title }}
                                </a>
                            </h2>
                        </div>

                        <div class="year-dir">
                            <span class="year">
                                {{ $review->movie->year }}
                            </span>

                            <span class="dir">
                                • Dir. {{ $review->movie->director }}
                            </span>
                        </div>

                        <p>
                            Rating:
                            {{ $review->rating }}/5
                        </p>

                    </div>
                </div>

                <p>
                    {{ $review->review }}
                </p>

                <small>
                    {{ substr($review->created_at, 0, 10) }}

                    <span>
                        • {{ $review->user->username }}
                    </span>
                </small>

            </article>

        @endforeach
        

    </main>
<div class="bottom-paginate">
    {{ $reviews->links() }}
</div>
@endsection