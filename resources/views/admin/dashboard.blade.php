@php
    use Carbon\Carbon;
    use App\Models\Sponsor;
@endphp
@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('main-content')
        
    {{-- Inizio Main --}}
    <main>
        <!-- Inizio Container Tabelle -->
        <div class="container p-0 my-table-container">

            <!-- Inizio 2^ Row  -->
            <div class="row">

                <!-- Inizio Colonna Sx Container Tabelle-->
                <div class="col-12 col-lg-8 pt-3">

                    {{-- Creo una condizione per cui se l'utente ha appartamenti allora vengono mostrati --}}
                    @if($userApartments->isNotEmpty())
                    
                        <!-- Inizio Tabella Appartamenti -->
                        <div class="table-responsive">
                            <table class="table table-hover text-center apt-table">

                                {{-- Inizio Testata Tabella --}}
                                <thead>
                                    <tr>
                                        <th class="col-6 text-start table-titles">
                                            I tuoi appartamenti
                                        </th>
                                        <th class="d-none d-sm-block text-start table-titles" >Città</th>
                                        <th class="text-start table-titles">Sponsor</th>
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
                                                        <span>
                                                            <i class="fa-solid fa-link"></i>
                                                        </span>
                                                        {{ $singleApartment->title }}
                                                    </a>
                                                </span>
                                            </td>
                                            <td class="d-none d-sm-block text-start">
                                                @php
                                                    $apartmentAddress = $singleApartment->address;
                                                    $addressParts = explode(',', $apartmentAddress);
                                                    $city = end($addressParts);
                                                    $cityParts = explode(' ', trim($city));
                                                    $newApartmentAddress = end($cityParts);
                                                @endphp
                                                {{ $newApartmentAddress }}
                                            </td>
                                            <td class="text-start">
                                                @php
                                                    // Recupera l'ultima sponsorizzazione attiva dell'appartamento
                                                    $latestSponsorship = DB::table('apartment_sponsor')
                                                        ->where('apartment_id', $singleApartment->id)
                                                        ->where('date_end', '>=', Carbon::now())
                                                        ->orderBy('date_end', 'desc')
                                                        ->first();

                                                    // Inizializza la variabile del titolo dello sponsor
                                                    $sponsorTitle = null;

                                                    // Se la sponsorizzazione è attiva, ottieni il titolo dello sponsor
                                                    if ($latestSponsorship) {
                                                        $sponsor = Sponsor::find($latestSponsorship->sponsor_id);
                                                        if ($sponsor) {
                                                            $sponsorTitle = $sponsor->title;
                                                        }
                                                    }
                                                @endphp

                                                @if ($latestSponsorship)
                                                    @if ($latestSponsorship->sponsor_id == 1)
                                                        <span class="badgetext-bg-silver px-1">
                                                            {{ $sponsorTitle }}
                                                            <i class="fa-solid fa-certificate"></i>
                                                        </span>
                                                    @elseif ($latestSponsorship->sponsor_id == 2)
                                                        <span class="badgetext-bg-gold px-1">
                                                            {{ $sponsorTitle }}
                                                            <i class="fa-solid fa-certificate"></i>
                                                        </span>
                                                    @elseif ($latestSponsorship->sponsor_id == 3)
                                                        <span class="badgetext-bg-platinum px-1">
                                                            {{ $sponsorTitle }}
                                                            <i class="fa-solid fa-certificate"></i>
                                                        </span>
                                                    @endif
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
                        <p>Non hai ancora nessun appartamento.</p>
                    @endif

                </div>
                <!-- Fine Colonna Sx -->

                <!-- Inizio Colonna Dx -->
                <div class="col-12 col-lg-4 pt-3">

                    <div class="row g-0">
                        <h5>
                            Gli appartamenti preferiti dai tuoi ospiti
                        </h5>

                        <!-- Inizio Card Stats Views -->
                        <div class="mb-2">
                            <div class="card border-0">
                                <ul class="list-group list-group-flush">
                                    @foreach ($userTopApartments as $singleUserTopApartment)
                                        <li class="list-group-item fst-italic">
                                            {{ $singleUserTopApartment->title }}
                                            <span class="fw-light"> -  {{ $singleUserTopApartment->views_count }} visualizzazioni</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>                              
                        </div> 
                        <!-- Fine Card Stats Views -->

                        <!-- Inizio Card Stats Messaggi -->
                        <div>
                            <div class="card border-0">
                                <ul class="list-group list-group-flush">
                                    @foreach ($userApartmentsWithMostMessages as $singleUserTopApartment)
                                        <li class="list-group-item fst-italic">
                                            {{ $singleUserTopApartment->title }}
                                            <span class="fw-light"> -  {{ $singleUserTopApartment->messages_count }} messaggi</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>                              
                        </div> 
                        <!-- Fine Card Stats Messaggi -->


                    </div>

                    
                </div>
                <!-- Inizio Colonna Dx -->

            </div>
            <!-- Fine 2^ Row -->

        </div>
        <!-- Fine Container Tabelle -->
    </main>
    {{-- Fine Main --}}
@endsection
