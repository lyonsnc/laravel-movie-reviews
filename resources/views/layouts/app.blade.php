<!DOCTYPE hmtl>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device=width, initial-scale=1.0">
    <title>@yield('title', 'Movie Reviews')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
{{-- Flash Message --}}
@if (session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="error-message">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

{{-- Navigation --}}
<nav class="navbar">

    <div class="nav-left">

        <a href="{{ route('home') }}">
            <img
                    src="{{ asset('filmreel.jpg') }}"
                    alt="Film Archive logo"
                    class="nav-logo"
            >
        </a>

        <a href="{{route('movies.search')}}">
            Search Movies 
        </a>
    </div>
    <div></div>
    <div class="nav-right">
        @auth 
            <a href="{{route('profile')}}">
                Profile 
            </a>
            <form
                method="POST"
                action="{{ route('logout') }}"
                class="logout-form"
            >
                @csrf

                <button type="submit" class="nav-logout-button">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login', ['redirect' => request()->getRequestUri()]) }}">
                Login
            </a>

            <a href="{{ route('register') }}">
                Register
            </a>
        @endauth
    </div>
</nav>

{{-- General flash message --}}
@if (session('message'))
    <div class="flash-message" id="flash-message">
        {{ session('message') }}
    </div>
@endif

<main>
    @yield('content')
</main>


{{-- Page-specific JavaScript --}}
@stack('scripts')

</body>
</html>