<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
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

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item">
                        <a href="{{route('home')}}" class="nav-link">Dashboard</a>
                        </li>
                        @if (auth()->user()->id == 1)
                            <li class="nav-item">
                                <a href="{{route('inventories.index')}}" class="nav-link">Inventories</a>
                            </li>
                        @endif
                        @can('viewAny', \App\Product::class)
                            <li class="nav-item">
                                <a href="{{route('products.index')}}" class="nav-link">My Inventory</a>
                            </li>
                        @endcan
                        @can('viewAny', \App\User::class)
                            <li class="nav-item">
                                <a href="{{route('suppliers.index')}}" class="nav-link">Suppliers</a>
                            </li>
                        @endcan
                        @if (auth()->user()->id == 1)
                            <li class="nav-item">
                                <a href="{{route('checkout.index')}}" class="nav-link">Checkout</a>
                            </li>
                        @endif
                        @if (auth()->user()->id == 1)
                            <li class="nav-item">
                            <a href="{{route('carts.index')}}" class="nav-link">Cart {!!\App\Cart::where('order_id',null)->get()->count() ? "<span class='badge badge-primary'>".\App\Cart::where('order_id',null)->get()->count()."</span>" : ""!!}</a>
                            </li>
                        @endif
                        @if (auth()->user()->id == 1)
                            <li class="nav-item">
                            <a href="{{route('receipts.index')}}" class="nav-link">Receipts</a>
                            </li>
                        @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if (session('success'))
                        
                        <div class="alert alert-success" role="alert">
                            {{session('success')}}
                        </div>
    
                    @endif
                    @if ($errors)
                        
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{$error}}
                            </div>
                        @endforeach
    
                    @endif
                </div>
            </div>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
