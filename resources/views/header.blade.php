<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('signup') }}">Signup</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('profile') }}">My Account</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="product.php">Membership</a>
            </li>
            <?php $user = auth()->user(); ?>
            @if ($user)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                        {{ __('signout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endif
        </ul>
    </div>


</nav>
