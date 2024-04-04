@php
    $userApartments = App\Models\Apartment::where('user_id', auth()->id())->get();
    $totalUserApartments = $userApartments->count();


    // Controllo quante volte sono state visualizzati in totale gli appartamenti
    $userViews = DB::table('views')
                    ->join('apartments', 'views.apartment_id', '=', 'apartments.id')
                    ->where('apartments.user_id', auth()->id())
                    ->count();
    // Controllo quali sono gli appartamenti con più visualizzazioni
    $userTopApartments = DB::table('apartments')
                                    ->join('views', 'apartments.id', '=', 'views.apartment_id')
                                    ->where('apartments.user_id', auth()->id())
                                    ->select('apartments.*', DB::raw('COUNT(views.id) as views_count'))
                                    ->groupBy('apartments.id')
                                    ->orderByDesc('views_count')
                                    ->take(3)
                                    ->get();
    // Controllo quanti messaggi sono stati mandati in totale
    $userMessages = DB::table('contacts')
                    ->join('apartments', 'contacts.apartment_id', '=', 'apartments.id')
                    ->where('apartments.user_id', auth()->id())
                    ->count();
    // Controllo quali sono gli appartamenti con più messaggi   
    $userApartmentsWithMostMessages = DB::table('apartments')
                                        ->join('contacts', 'apartments.id', '=', 'contacts.apartment_id')
                                        ->where('apartments.user_id', auth()->id())
                                        ->select('apartments.*', DB::raw('COUNT(contacts.id) as messages_count'))
                                        ->groupBy('apartments.id')
                                        ->orderByDesc('messages_count')
                                        ->take(3)
                                        ->get();
@endphp

@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('main-content')

    <!-- Inizio Header -->
    <header>
        <div class="text-white h-100">
            
            <div class="row align-items-center h-100 m-0">
                <!-- Inizio Colonna Search Bar -->
                {{-- <div class="col">
                    <form action="#">
                        <div class="input-group">
                            <span class="my-navbar border-end-0 input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-start-0 my-navbar" placeholder="Prova a cercare: Lezioni di Laravel" aria-label="Prova a cercare: Lezioni di Laravel" aria-describedby="basic-addon1">
                        </div>    
                    </form>
            
                </div> --}}
                <!-- Fine Colonna Search Bar -->

                <!-- Inizio Colonna Bottoni -->
                <div class="col-auto ms-auto user">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <!-- Inizio Bottone Dropdown -->
                        <div class="btn-group my-button" role="group">
                            <button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $user->name }} {{ $user->lastname }}                    
                            </button>
                            <ul class="dropdown-menu">
                                <li class="d-none d-lg-block">
                                    <h6>
                                        Email:
                                    </h6>
                                    {{ $user->email }}
                                </li>
                                <li class="d-none d-lg-block">
                                    <h6>
                                        Data di nascita:
                                    </h6>
                                    {{$user->birthday}}                                
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
                <!-- Fine Colonna Bottoni -->

            </div>
        </div>
    </header>
    <!-- Fine Header -->
        
    {{-- Inizio Main --}}
    <main>
        <!-- Inizio Container Tabelle -->
        <div class="container-fluid p-0 my-table-container">

            <!-- Inizio 2^ Row  -->
            <div class="row">

                <!-- Inizio Colonna Sx Container Tabelle-->
                <div class="col-12 col-lg-8 pt-3">

                    {{-- Creo una condizione per cui se l'utente ha appartamenti allora vengono mostrati --}}
                    @if($userApartments->isNotEmpty())
                    
                        <!-- Inizio Tabella Appartamenti -->
                        <div class="table-responsive">
                            <table class="table caption-top border text-center">

                                <!-- Titolo Tabella -->
                                <caption class="border rounded-top-2">
                                    <h5 class="ps-2 fs-4">
                                        Numero Totale Appartamenti: {{ $totalUserApartments }}
                                    </h5>
                                </caption>
                                {{-- Inizio Testata Tabella --}}
                                <thead>
                                    <tr>
                                    <th class="col-6 text-start">
                                        Nome Appartamento
                                    </th>
                                    <th>Città</th>
                                    <th>Sponsor</th>
                                    </tr>
                                </thead>
                                {{-- Fine Testata Tabella --}}
                                <!-- Inizio Corpo Tabella -->
                                <tbody>
                                    @foreach ($userApartments as $singleApartment)
                                        <tr>
                                            <td class="text-start">
                                                <img src="img/class-avatar.jpg" alt="">
                                                <span>
                                                    <a href="{{ route('admin.apartments.show' , ['apartment' => $singleApartment->slug]) }}" class="text-decoration-none">
                                                        {{ $singleApartment->title }}
                                                    </a>
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $apartmentAddress = $singleApartment->address;
                                                    $addressParts = explode(',', $apartmentAddress);
                                                    $city = end($addressParts);
                                                    $cityParts = explode(' ', trim($city));
                                                    $newApartmentAddress = end($cityParts);
                                                @endphp
                                                {{ $newApartmentAddress }}
                                            </td>
                                            <td>
                                                @if ($singleApartment->sponsors)
                                                    @foreach ($singleApartment->sponsors as $sponsor)
                                                        @if ($sponsor->id == 1)
                                                            <span class="badgetext-bg-silver px-1">
                                                                {{ $sponsor->title }}
                                                            </span>
                                                        @elseif ($sponsor->id == 2)
                                                            <span class="badgetext-bg-gold px-1">
                                                                {{ $sponsor->title }}
                                                            </span>
                                                        @elseif ($sponsor->id == 3)
                                                            <span class="badgetext-bg-platinum px-1">
                                                                {{ $sponsor->title }}
                                                            </span>
                                                        @endif       
                                                    @endforeach
                                                @endif   
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>                
                        </div>
                        <!-- Fine Tabella Appartamenti-->

                    {{-- Altrimenti viene avvisato che ancora non ne ha --}}
                    @else
                        <p>Non hai ancora aggiunto nessun appartamento.</p>
                    @endif

                </div>
                <!-- Fine Colonna Sx -->

                <!-- Inizio Colonna Dx -->
                <div class="col-12 col-lg-4 pt-3">

                    <!-- Inizio Card Stats Views -->
                    <div class="card p-2">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                <h5>
                                    I tuoi appartamenti hanno {{ $userViews }} visualizzazioni.
                                </h5>
                                </li>
                                @foreach ($userTopApartments as $singleUserTopApartment)
                                    <li class="list-group-item">
                                        {{ $singleUserTopApartment->title }}
                                        <span> -  {{ $singleUserTopApartment->views_count }} visualizzazioni</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>                              
                    </div> 
                    <!-- Fine Card Stats Views -->

                    <!-- Inizio Card Stats Messaggi -->
                    <div class="card p-2">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                <h5>
                                    I tuoi appartamenti hanno {{ $userMessages }} messaggi.
                                </h5>
                                <span>{{ $userViews }}</span> volte
                                </li>
                                @foreach ($userApartmentsWithMostMessages as $singleUserTopApartment)
                                    <li class="list-group-item">
                                        {{ $singleUserTopApartment->title }}
                                        <span> -  {{ $singleUserTopApartment->messages_count }} messaggi</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>                              
                    </div> 
                    <!-- Fine Card Stats Messaggi -->
                    
                </div>
                <!-- Inizio Colonna Dx -->

            </div>
            <!-- Fine 2^ Row -->

        </div>
        <!-- Fine Container Tabelle -->
    </main>
    {{-- Fine Main --}}
@endsection
