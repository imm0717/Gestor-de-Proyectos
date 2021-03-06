<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/general/Date-Time-Picker-Bootstrap-4/build/css/bootstrap-datetimepicker.css') }}"
        rel="stylesheet">
    <link href="{{ asset('vendor/general/bootstrap-select-1.13.0-dev/dist/css/bootstrap-select.min.css') }}"
        rel="stylesheet">

    @livewireStyles
    @stack('styles')

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @if (Route::has('home'))
                                <li class="nav-item">
                                    <a class="nav-link {{ \Illuminate\Support\Facades\Route::current()->getName() == 'home' ? 'active' : '' }}"
                                        href="{{ route('home') }}">{{ __('Dashboard') }}</a>
                                </li>
                            @endif
                            @if (Route::has('projects'))
                                <li class="nav-item">
                                    <a class="nav-link {{ \Illuminate\Support\Facades\Route::current()->getName() == 'projects' ? 'active' : '' }}"
                                        href="{{ route('projects') }}">{{ __('My Projects') }}</a>
                                </li>
                            @endif
                            @if (Route::has('tasks'))
                                <li class="nav-item">
                                    <a class="nav-link {{ \Illuminate\Support\Facades\Route::current()->getName() == 'tasks' ? 'active' : '' }}"
                                        href="{{ route('tasks') }}">{{ __('My Tasks') }}</a>
                                </li>
                            @endif
                            @if (Route::has('processes'))
                                <li class="nav-item">
                                    <a class="nav-link {{ \Illuminate\Support\Facades\Route::current()->getName() == 'processes' ? 'active' : '' }}"
                                        href="{{ route('processes') }}">{{ __('Processes') }}</a>
                                </li>
                            @endif
                            @if (Route::has('logs'))
                                <li class="nav-item">
                                    <a class="nav-link {{ \Illuminate\Support\Facades\Route::current()->getName() == 'logs' ? 'active' : '' }}"
                                        href="{{ route('logs') }}">{{ __('Logs') }}</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset('vendor/general/bootstrap-select-1.13.0-dev/dist/js/bootstrap-select.min.js') }}">
    </script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="{{ asset('vendor/general/bootstrap-select-1.13.0-dev/dist/js/i18n/defaults-es_ES.min.js') }}">
    </script>

    <script
        src="{{ asset('vendor/general/Date-Time-Picker-Bootstrap-4/build/js/bootstrap-datetimepicker.min.js') }}">
    </script>

    @livewireScripts
    <script>
        window.addEventListener('alert', event => {
            $('.toast').toast({
                'animation': true,
                'autohide': true,
                'delay': 5000
            });
            $('.toast').toast('show');
        })
    </script>
    @stack('scripts')

</body>

</html>
