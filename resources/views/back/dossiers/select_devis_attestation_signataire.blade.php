@extends('back.layouts.principal')

@section('title', 'Sélectionner un devis')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="fw-bold text-dark mb-4">
        Sélectionnez un devis pour créer une attestation de signature
    </h4>

    <div class="row">
        @foreach($devisList as $devis)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">
                            {{ $devis->reference_devis ?? $devis->reference }}
                        </h5>

                        <p class="card-text text-muted">
                            {{ $devis->nom_residence }} <br>
                            {{ $devis->adresse_travaux }}
                        </p>

                        <div class="mt-auto">
                            <a href="{{route('back.document.attestation-signataire.create',[$activity, $society, $devis->id]) }}"
                            class="btn btn-success w-100">
                                Créer l’attestation signataire
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if($devisList->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Aucun devis disponible pour cette société.
                </div>
            </div>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('back.document.list', [$activity, $society, 'attestation_signataire']) }}">
           class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>
@endsection
