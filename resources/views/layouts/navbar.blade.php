<li>
    <a href="{{ route('home') }}">Home</a>
</li>
@if(!Auth::guest())
    <li>
        Welcome {{auth()->user()->name}}
    </li>
    <li>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
@else
    <li>
        <a href="{{ route('login') }}">Login</a>
    </li>
    <li>
        <a href="{{ route('register') }}">Register</a>
    </li>
@endif
