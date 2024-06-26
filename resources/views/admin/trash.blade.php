@extends('layouts.app')

@section('page-title', 'Tutti gli appartamenti')

@section('main-content')

    <section id="apartments">

        <div class="m-3 col-7">
            {{-- input per il filtraggio dei dati --}}
            <label for="filter" class="form-label">Cerca</label>
            <input type="text" name="filter" id="filter" class="form-control">
        </div>
        <div class="container">

            <h1>
                i tuoi appartamenti eliminati
            </h1>    

            <div class="row g-0">

                @foreach ($apartment as $singleApartment)
                
                    <div class="my-card">
                        @if ($singleApartment->cover_img != null)
                            <img src="{{ $singleApartment->full_cover_img }}" alt="{{$singleApartment->title}}">
                        @endif
                        <h3>
                            {{$singleApartment->title}}
                        </h3>
                        <p>
                            {{ $singleApartment->city }}
                            <br>
                            {{ $singleApartment->address }}
                        </p>
                            {{-- Bottone di eliminazione che apre una modale --}}
                            {{-- <button class="erase-button" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $singleApartment->slug }}">
                                <i class="fa-solid fa-eraser"></i>
                            </button> --}}

                            {{-- Modale per l'eliminazione dell'appartamento --}}
                            <div class="modal fade" id="staticBackdrop-{{ $singleApartment->slug }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                Eliminazione Appartamento
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                        </div>
                                        <div class="modal-body">
                                            Sei sicuto di voler eliminare: <b> {{ $singleApartment->title }} </b> ?
                                        </div>
                                        {{-- <div class="modal-footer">
 
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                             Creiamo il form per l'eliminazione che con l'action reindirizza alla rotta destroy del controller, 
                                            come argomento passo lo slug del singolo appartamento
                                            <form 
                                            action="{{ route('admin.apartments.destroy', ['apartment' => $singleApartment]) }}" 
                                            method="POST">
                                            @csrf
                                             Richiamo il metodo DELETE che non può essere inserito nel FORM 
                                            @method('DELETE')
                                                <button 
                                                    type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    Elimina
                                                </button>
                                            </form>
                                            
                                        </div> --}}
                                        {{-- <form action="{{ route('admin.apartments.restore', $apartment->slug) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit">Ripristina</button>
                                        </form> --}}
                                        
                                    </div>
                                </div>
                            </div>
                        </div>      
                    </div>
                @endforeach

            </div>

        </div>
    </section>
    <script>
        //assegno una variabile all elemento con id filter
        let input_filter = document.getElementById('filter');
        //evento che si scatena ad ogni input nel tag
        input_filter.addEventListener('input',function(){
            //faccio diventare tutta la value dell'input in minuscolo
            const filter = input_filter.value.toLowerCase();
            //prendo tutti gli elementi della classe my-cards
            let cards = document.querySelectorAll('.my-card');
            //ciclo nella variabile cards che ha restituito una NodeList
            cards.forEach(function(card){
                //il contenuto degli h3 li prendo in minuscolo
                let title = card.querySelector('h3').textContent.toLowerCase();
                //se la codizione viene rispettata aggiungo una classe se no ne aggiungo un altra
                if (title.includes(filter)) {
                    card.style.display = 'block';
                }
                else{
                    card.style.display = 'none';
                }
            });
        })

    </script>

@endsection
