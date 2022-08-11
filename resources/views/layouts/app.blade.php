<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', "Zen's Sushi") }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script>
        var assetBaseUrl = "{{ asset('') }}";
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/a94b89670e.js"></script>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('links')
    
</head>
<body id="@yield('bodyID')">
    <header>
        <nav data-theme="@yield('navTheme')" class="home-nav @yield('navTheme')">
            <a href="/" class="logo-wrapper">
                <img class="logo" src="@yield('logoFileName')" alt="logo">
            </a>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="{{ route('car') }}">Car</a></li>
                @guest
                    <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                @else
                    @if (auth()->user()->role == 'customer')
                    <li><a href="{{ route('cart') }}">Cart</a></li>
                    <li><a href="{{ route('order') }}">Order</a></li>
                    @elseif (auth()->user()->role != 'customer')
                    <li><a href="{{ route('kitchenOrder') }}">Order</a></li>
                    @if (auth()->user()->role == 'admin')
                    <li><a href="{{ route('discount') }}">Discount</a></li>
                    @endif
                    @endif
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container footer-wrapper">
        <div class="row footer-content">
            <div class="col-sm-12 col-md-6 col-lg-4 open-hours">
                <div class="title-wrapper">
                    <h3>Operation</h3>
                </div>
                <div class="footer-detail">
                    <p>Monday: Closed</p>
                </div>
                <div class="footer-detail">
                    <p><b>Tuesday to Friday</b></p>
                    <p>7:00 AM - 9:00 PM</p>
                </div>
                <div class="footer-detail">
                    <p><b>Saturday & Sunday</b></p>
                    <p>11:00 AM - 10:00 PM</p>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-4 find-us">
                <div class="title-wrapper">
                    <h3 class="title">Location</h3>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 2.25C14.7191 2.25387 11.5738 3.5589 9.25384 5.87883C6.93392 8.19875 5.62888 11.3441 5.62501 14.625C5.62108 17.3061 6.49687 19.9145 8.11801 22.05C8.11801 22.05 8.45551 22.4944 8.51064 22.5585L18 33.75L27.4939 22.5529C27.5434 22.4933 27.882 22.05 27.882 22.05L27.8831 22.0466C29.5035 19.9121 30.3789 17.3049 30.375 14.625C30.3711 11.3441 29.0661 8.19875 26.7462 5.87883C24.4263 3.5589 21.2809 2.25387 18 2.25ZM18 19.125C17.11 19.125 16.24 18.8611 15.4999 18.3666C14.7599 17.8721 14.1831 17.1693 13.8426 16.3471C13.502 15.5248 13.4128 14.62 13.5865 13.7471C13.7601 12.8742 14.1887 12.0724 14.818 11.443C15.4474 10.8137 16.2492 10.3851 17.1221 10.2115C17.995 10.0378 18.8998 10.1269 19.7221 10.4675C20.5444 10.8081 21.2472 11.3849 21.7416 12.1249C22.2361 12.865 22.5 13.735 22.5 14.625C22.4985 15.818 22.0239 16.9617 21.1803 17.8053C20.3368 18.6489 19.193 19.1235 18 19.125Z" fill="#F4695B"/>
                    </svg>
                </div>
                <div class="footer-detail">
                    <p>123, Jalan Hicom 1,</p>
                    <p>Shah Alam,</p>
                    <p>47600, Selangor.</p>
                </div>
            </div>

            <div class="col-sm-12 col-lg-4 social">
                <div class="title-wrapper">
                    <h3>Social Media</h3>
                </div>
                <div class="footer-detail">
                    <div class="media-link">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 18.1005C0 27.0495 6.4995 34.491 15 36V22.9995H10.5V18H15V13.9995C15 9.4995 17.8995 7.0005 22.0005 7.0005C23.2995 7.0005 24.7005 7.2 25.9995 7.3995V12H23.7C21.4995 12 21 13.0995 21 14.5005V18H25.8L25.0005 22.9995H21V36C29.5005 34.491 36 27.051 36 18.1005C36 8.145 27.9 0 18 0C8.1 0 0 8.145 0 18.1005Z" fill="#F4695B"/>
                        </svg>
                        <p>@ProtonStore</p>
                    </div>
                    <div class="media-link">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1975 1.599C12.957 1.518 13.518 1.5 18 1.5C22.482 1.5 23.043 1.5195 24.801 1.599C26.559 1.6785 27.759 1.959 28.809 2.3655C29.9085 2.781 30.906 3.4305 31.731 4.2705C32.571 5.094 33.219 6.09 33.633 7.191C34.041 8.241 34.32 9.441 34.401 11.196C34.482 12.9585 34.5 13.5195 34.5 18C34.5 22.482 34.4805 23.043 34.401 24.8025C34.3215 26.5575 34.041 27.7575 33.633 28.8075C33.219 29.9086 32.5699 30.9063 31.731 31.731C30.906 32.571 29.9085 33.219 28.809 33.633C27.759 34.041 26.559 34.32 24.804 34.401C23.043 34.482 22.482 34.5 18 34.5C13.518 34.5 12.957 34.4805 11.1975 34.401C9.4425 34.3215 8.2425 34.041 7.1925 33.633C6.09138 33.2189 5.09373 32.5699 4.269 31.731C3.42957 30.907 2.77997 29.9098 2.3655 28.809C1.959 27.759 1.68 26.559 1.599 24.804C1.518 23.0415 1.5 22.4805 1.5 18C1.5 13.518 1.5195 12.957 1.599 11.199C1.6785 9.441 1.959 8.241 2.3655 7.191C2.78058 6.09012 3.43068 5.09297 4.2705 4.269C5.09406 3.42975 6.09071 2.78017 7.191 2.3655C8.241 1.959 9.441 1.68 11.196 1.599H11.1975ZM24.6675 4.569C22.9275 4.4895 22.4055 4.473 18 4.473C13.5945 4.473 13.0725 4.4895 11.3325 4.569C9.723 4.6425 8.85 4.911 8.268 5.1375C7.4985 5.4375 6.948 5.793 6.3705 6.3705C5.82307 6.90308 5.40177 7.55142 5.1375 8.268C4.911 8.85 4.6425 9.723 4.569 11.3325C4.4895 13.0725 4.473 13.5945 4.473 18C4.473 22.4055 4.4895 22.9275 4.569 24.6675C4.6425 26.277 4.911 27.15 5.1375 27.732C5.4015 28.4475 5.823 29.097 6.3705 29.6295C6.903 30.177 7.5525 30.5985 8.268 30.8625C8.85 31.089 9.723 31.3575 11.3325 31.431C13.0725 31.5105 13.593 31.527 18 31.527C22.407 31.527 22.9275 31.5105 24.6675 31.431C26.277 31.3575 27.15 31.089 27.732 30.8625C28.5015 30.5625 29.052 30.207 29.6295 29.6295C30.177 29.097 30.5985 28.4475 30.8625 27.732C31.089 27.15 31.3575 26.277 31.431 24.6675C31.5105 22.9275 31.527 22.4055 31.527 18C31.527 13.5945 31.5105 13.0725 31.431 11.3325C31.3575 9.723 31.089 8.85 30.8625 8.268C30.5625 7.4985 30.207 6.948 29.6295 6.3705C29.0969 5.82311 28.4486 5.40182 27.732 5.1375C27.15 4.911 26.277 4.6425 24.6675 4.569ZM15.8925 23.0865C17.0695 23.5764 18.3801 23.6426 19.6004 23.2736C20.8207 22.9046 21.8751 22.1234 22.5834 21.0634C23.2917 20.0034 23.6101 18.7303 23.4841 17.4617C23.3581 16.193 22.7955 15.0075 21.8925 14.1075C21.3169 13.5322 20.6208 13.0917 19.8545 12.8177C19.0882 12.5437 18.2706 12.443 17.4607 12.5229C16.6508 12.6028 15.8687 12.8613 15.1707 13.2797C14.4727 13.6981 13.8761 14.2661 13.424 14.9428C12.9718 15.6194 12.6753 16.3879 12.5558 17.1929C12.4363 17.9979 12.4967 18.8194 12.7328 19.5983C12.9689 20.3771 13.3747 21.0939 13.9211 21.6971C14.4674 22.3003 15.1407 22.7748 15.8925 23.0865ZM12.003 12.003C12.7905 11.2155 13.7255 10.5908 14.7544 10.1645C15.7834 9.73833 16.8863 9.51896 18 9.51896C19.1137 9.51896 20.2166 9.73833 21.2456 10.1645C22.2745 10.5908 23.2095 11.2155 23.997 12.003C24.7845 12.7905 25.4092 13.7255 25.8355 14.7544C26.2617 15.7834 26.481 16.8863 26.481 18C26.481 19.1137 26.2617 20.2166 25.8355 21.2456C25.4092 22.2745 24.7845 23.2095 23.997 23.997C22.4065 25.5875 20.2493 26.481 18 26.481C15.7507 26.481 13.5935 25.5875 12.003 23.997C10.4125 22.4065 9.51896 20.2493 9.51896 18C9.51896 15.7507 10.4125 13.5935 12.003 12.003ZM28.362 10.782C28.5572 10.5979 28.7134 10.3765 28.8215 10.131C28.9295 9.8854 28.9872 9.62065 28.9911 9.3524C28.995 9.08414 28.9451 8.81782 28.8442 8.56921C28.7434 8.32061 28.5936 8.09477 28.4039 7.90506C28.2142 7.71535 27.9884 7.56564 27.7398 7.46478C27.4912 7.36392 27.2249 7.31396 26.9566 7.31787C26.6883 7.32178 26.4236 7.37948 26.178 7.48754C25.9325 7.59561 25.7111 7.75184 25.527 7.947C25.169 8.32654 24.9729 8.83068 24.9806 9.3524C24.9882 9.87411 25.1988 10.3723 25.5677 10.7413C25.9367 11.1102 26.4349 11.3208 26.9566 11.3284C27.4783 11.3361 27.9825 11.14 28.362 10.782Z" fill="#F4695B"/>
                        </svg>
                        <p>@ProtonStore</p>
                    </div>
                    <div class="media-link">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M35.4645 7.40562C34.212 7.96062 32.8665 8.33562 31.452 8.50512C32.9115 7.6318 34.0034 6.25731 34.524 4.63812C33.1528 5.4526 31.652 6.02591 30.087 6.33312C29.0346 5.20941 27.6406 4.4646 26.1215 4.21433C24.6024 3.96405 23.0432 4.2223 21.6859 4.94899C20.3286 5.67569 19.2492 6.83016 18.6152 8.23317C17.9813 9.63618 17.8283 11.2092 18.18 12.7081C15.4015 12.5686 12.6835 11.8464 10.2022 10.5885C7.72085 9.33051 5.53178 7.56486 3.77702 5.40612C3.17702 6.44112 2.83202 7.64112 2.83202 8.91912C2.83135 10.0696 3.11467 11.2025 3.65684 12.2172C4.199 13.2319 4.98326 14.0972 5.94002 14.7361C4.83043 14.7008 3.74533 14.401 2.77502 13.8616V13.9516C2.77491 15.5652 3.33307 17.1292 4.35479 18.3781C5.37652 19.627 6.79887 20.484 8.38052 20.8036C7.35119 21.0822 6.27202 21.1232 5.22452 20.9236C5.67076 22.312 6.54001 23.5262 7.71057 24.396C8.88113 25.2659 10.2944 25.7479 11.7525 25.7746C9.27727 27.7177 6.22035 28.7717 3.07352 28.7671C2.51609 28.7673 1.95913 28.7347 1.40552 28.6696C4.59973 30.7234 8.31803 31.8133 12.1155 31.8091C24.9705 31.8091 31.998 21.1621 31.998 11.9281C31.998 11.6281 31.9905 11.3251 31.977 11.0251C33.344 10.0366 34.5239 8.81246 35.4615 7.41012L35.4645 7.40562Z" fill="#F4695B"/>
                        </svg>
                        <p>@ProtonStore</p>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="copyright">
            <p>Copyright © 2022 All Rights Reserved by ProtonStore, Inc.</p>
        </div>

        </div>
    </footer>
</body>
</html>
