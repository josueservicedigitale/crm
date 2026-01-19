@extends('back.layouts.principal')

@section('title', 'Sélectionner un devis')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="fw-bold text-dark mb-4">
        Sélectionnez un devis pour créer une facture
    </h4>

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
    </div>
</div>
@endsection
