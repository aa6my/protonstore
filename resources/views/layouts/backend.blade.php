

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', "Zen's Sushi") }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script>
        var assetBaseUrl = "{{ asset('') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/backend.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/a94b89670e.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">

    @yield('links')

</head>
<body id="@yield('bodyID')">
    <header>
        <nav data-theme="@yield('navTheme')" class="home-nav @yield('navTheme')">
            <a href="/" class="logo-wrapper">
                <img class="logo" src="@yield('logoFileName')" alt="logo">
                <h3 class="logo-name">{{ config('app.name') }}</h3>
            </a>
            <ul class="nav-links">
            @if (auth()->user()->role == 'admin')
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('carOrder') }}">Orders</a></li>
                <li><a href="{{ route('car') }}">Car</a></li>
                <li><a href="{{ route('discount') }}">Discount</a></li>
                <li><a href="{{ route('createAccount') }}">Account</a></li>
            @endif
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>

    <div class="sidebar">
        <header>
            <img id="logo" src="@yield('logoFileName')" alt="logo">
        </header>
        <ul>
        @if (auth()->user()->role == 'admin')
            <li ><a href="{{ route('dashboard') }}" id="sidebar-dashboard"><i class="fa fa-th-large" aria-hidden="true"></i>Dashboard</a></li>
            <br>
            <li ><a href="{{ route('carOrder') }}" id="sidebar-orders"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Orders</a></li>
            <br>
            <li ><a href="{{ route('car') }}" id="sidebar-car"><i class="fa fa-book" aria-hidden="true"></i>Car</a></li>
            <br>
            <li ><a href="{{ route('discount') }}" id="sidebar-discount"><i class="fa fa-ticket" aria-hidden="true"></i>Discount</a></li>
            <br>
            <li ><a href="{{ route('createAccount') }}" id="sidebar-account"><i class="fa fa-user" aria-hidden="true"></i>Account</a></li>
            <br>
        @else
            <li ><a href="{{ route('carOrder') }}" id="sidebar-orders"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Orders</a></li>
            <br>
        @endif
            <li >
                <a href="{{ route('logout') }}" id="sidebar-logout" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>{{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            
        </ul>
    </div>

    <div class="container">
        <div class="pl-250">
        @yield('content')
        </div>
    </div>
    
</body>
</html>