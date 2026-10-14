@extends('layouts.app')

@section('title', 'Add Review')

@section('content')

<h1>Add Review</h1>

<!-- POST form in question -->
<div class="add-review-box">
<form method="POST" action="{{ route('reviews.store') }}" class="add-review-form">
    @csrf
    <div class="movie-header">
        <div class="movie-details">
        <div class="clickable-title">
                <h2>
                    <a href="{{ route('movies.show', $movie['id']) }}">
                        {{ $movie['title'] }}
                    </a>
                </h2>
        </div>
    
        <div class="year-dir">
        <span class="year">{{ $year }}</span>
        <span class="dir">•  Dir. {{ $director }}</span>
        </div>

        <br>

        <label>
            Rating:
            <input type="number" name="rating" min="0" max="5" required>
        </label>

        <div class="overview" onclick="showSynopsis()">
            {{ substr($movie["overview"] ?? '', 0, 200) }}
            @if (strlen($movie["overview"] ?? '') > 200)
                ...
            @endif 
        </div>

        <div id="synopsis-overlay" class="synopsis-overlay" onclick="closeSynopsis()">
            <div class="synopsis-box" onclick="event.stopPropagation()">
                <p>{{ $movie['overview'] }}</p>
            </div>
        </div>
    </div>

        @if (!empty($movie["poster_path"]))
            <img class="add-review-poster" src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}
                alt={{ $movie['title'] }} poster"
            >
        @endif
    </div>

    <div class="review-input">
        <label>
            Review:
            <br>
            <textarea name="review" rows="6" cols="50" required></textarea>
        </label>
    </div>

    <input
        type="hidden"
        name="api_id"
        value="{{ $apiExternal }}"
    >
    <input
        type="hidden"
        name="title"
        value="{{ $movie['title'] }}"
    >
    <input
        type="hidden"
        name="year"
        value="{{ $year }}"
    >
    <input
        type="hidden"
        name="director"
        value="{{ $director }}"
    >
    <input
        type="hidden"
        name="poster"
        value="{{ $movie['poster_path'] }}"
    >

    <button type="submit">Submit Review</button>

</form>
</div>

@push('scripts')
<script>
    function showSynopsis() {
        document.getElementById("synopsis-overlay").style.display = "block";
    }

    function closeSynopsis() {
        document.getElementById("synopsis-overlay").style.display = "none";
    }
</script>
</body>
</html>
@endpush

@endsection