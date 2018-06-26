<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Browse <span class="caret"></span></a>

                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('threads.index') }}">All threads</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('threads.index') . '?popular' }}">All popular threads</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('threads.index') . '?unanswered' }}">Unanswered threads</a>
                        </li>

                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('threads.index') . '?by=' . auth()->user()->name }}">My threads</a>
                            </li>
                        @endauth
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('threads.create') }}" class="nav-link">New Thread</a>
                </li>

                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Channels <span class="caret"></span></a>

                    <ul class="dropdown-menu">
                        @foreach ($channels as $channel)
                            <li><a class="nav-link" href="/threads/{{ $channel->slug }}">{{ $channel->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="{{ route('profiles.show', Auth::user()) }}" class="dropdown-item">My Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
            </ul>
        </div>
    </div>
</nav>