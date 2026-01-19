@extends('back.layouts.principal')

@section('title', 'Sélectionner une facture')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="fw-bold text-dark mb-4">
        Sélectionnez une facture pour créer un rapport
    </h4>

    <div class="row">
        @foreach($factures as $facture)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $facture->reference_facture ?? $facture->reference }}</h5>

                        <p class="card-text text-muted">
                            {{ $facture->nom_residence }} <br>
                            {{ $facture->adresse_travaux }}
                        </p>

                        <div class="mt-auto">
                            <a href="{{ route('back.document.rapport.create', [$activity, $society, $facture->id]) }}"
                               class="btn btn-success w-100">
                                Créer le rapport
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if($factures->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Aucune facture disponible pour cette société.
                </div>
            </div>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('back.dashboard', [$activity, $society]) }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>
@endsection
