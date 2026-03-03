@extends('back.layouts.principal')

@section('title', 'Sélectionner un devis')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <h4 class="fw-bold text-dark mb-4">
            Sélectionnez un devis pour créer une facture
        </h4>
        <div class="sticky-search-wrapper mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <form method="GET" class="row g-3 align-items-center">

                        <div class="col-md-8">
                            <div class="input-group input-group-lg">

                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-primary"></i>
                                </span>

                                <input type="text" name="search" class="form-control border-start-0"
                                    placeholder="Entrez la référence du devis (ex : DV-2024-001)"
                                    value="{{ request('search') }}">

                                @if(request('search'))
                                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary" title="Réinitialiser">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif

                            </div>
                        </div>

                        <div class="col-md-4 text-md-end">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-search me-2"></i>Rechercher
                            </button>
                        </div>

                    </form>

                    @if(request('search'))
                        <div class="mt-3">
                            <span class="badge bg-light text-dark">
                                Résultats pour :
                                <strong>"{{ request('search') }}"</strong>
                            </span>

                            <span class="ms-2 text-muted">
                                {{ $devisList->count() }} résultat(s) trouvé(s)
                            </span>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="row">
            @foreach($devisList as $devis)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $devis->reference_devis }}</h5>
                            <p class="card-text">
                                Date: {{ $devis->date_devis }} <br>
                                Résidence: {{ $devis->nom_residence ?? '-' }}
                            </p>
                            <a href="{{ route('back.document.facture.create', [$activity, $society, $devis->id]) }}"
                                class="btn btn-success w-100">
                                Créer la facture
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach
            @if($devisList->isEmpty())
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Aucun devis trouvé pour cette recherche.
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection