@php
    $user = auth()->user();
    $initials = strtoupper(substr($user->name, 0, 1) . substr($user->lastname, 0, 1));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        {{-- Google Font --}}
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap'">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>@yield('page-title') | {{ config('app.name', 'Boolbnb') }}</title>

        <!-- Scripts -->
        @vite('resources/js/app.js')
    </head>
    <body>
        <main>
            <header class="row g-0 align-items-center"> 
                <div class="logo col-auto ms-2">
                    <a href="http://localhost:5174/" class="text-decoration-none" target="_blank">
                        <img src="{{ asset('logo.svg') }}" alt="Logo" class="logo_container">
                    </a>
                </div>   
                <div class="col-auto flex-grow-1">
                    <ul class="h-100 m-0">
                        <li>
                            <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <span class="d-lg-block d-none fw-semibold">
                                    Dashboard
                                </span>
                                <i class="d-lg-none d-md-block fa-solid fa-table-columns"></i>
                            </a>
                        </li>
                        <li>
                            <a class="nav-link {{ Request::routeIs('admin.apartments.index') ? 'active' : '' }}" href="{{route('admin.apartments.index')}}">
                                <span class="d-lg-block d-none fw-semibold">
                                    Appartamenti
                                </span>
                                <i class="d-lg-none d-md-block fa-solid fa-house-user"></i>
                            </a>
                        </li>
                        
                        <li>
                            <a class="nav-link {{ Request::routeIs('admin.sponsors.index') ? 'active' : '' }}" href="{{ route('admin.sponsors.index') }}">
                                <span class="d-lg-block d-none fw-semibold">
                                    Sponsor
                                </span>
                                <i class="d-lg-none d-md-block fa-solid fa-certificate"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Inizio Colonna Bottoni -->
                <div class="col-auto user">
                    <div class="col-auto">
                        <div class="btn-group me-2" role="group" aria-label="Button group with nested dropdown">
                            <!-- Inizio Bottone Dropdown -->
                            <div class="btn-group my-button" role="group">
                                <button type="button" class="btn d-flex align-items-center justify-content-between p-1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-bars"></i>
                                    {{$initials }}   
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="d-lg-block m-0">
                                        <span class="fw-semibold d-flex align-items-center">
                                            <i class="fa-regular fa-circle-user pe-1"></i>
                                            {{$user->name}} {{ $user->lastname }}                             
                                        </span>
                                    </li>
                                    <li class="d-lg-block m-0">
                                        <span class="fw-semibold d-flex align-items-center">
                                            <i class="fa-solid fa-at pe-1"></i>
                                            {{ Str::limit($user->email,20, '...') }}
                                        </span>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="text-center">
                                            @csrf
                                            <button type="submit">
                                                Log Out
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>                            
                            <!-- Inizio Bottone Dropdown -->
                        </div>
                    </div>
                </div>
                <!-- Fine Colonna Bottoni -->
            </header>
            {{-- MAIN MENU --}}
            <div class="main-menu-container">
                {{-- TUTTO IL MENU --}} 
    
                <div class="container h-100">
                    @yield('main-content')
                </div>
            </div>
        </main>
    </body>
</html>
