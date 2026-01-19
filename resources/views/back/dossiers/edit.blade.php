@extends('back.layouts.principal')

@section('title', ucfirst($type) . ' - ' . strtoupper($society))

@section('content')
<div class="container-fluid pt-4 px-4">

    <h4 class="fw-bold text-dark">
        <i class="fa fa-file-alt me-2"></i>
        {{ strtoupper($society) }} – {{ ucfirst($activity) }}
    </h4>

    @if(isset($document))
        <form action="{{ route('back.document.update', [$activity, $society, $type, $document->id]) }}" method="POST">
        @method('PUT')
    @else
        <form action="{{ route('back.document.store', [$activity, $society, $type]) }}" method="POST">
    @endif
        @csrf

        @php
            function ro($condition) {
                return $condition ? 'readonly' : '';
            }
        @endphp

        {{-- ======================= DATE DYNAMIQUE ======================= --}}
        <div class="mb-3">
            <label>
                @if($type === 'facture')
                    Date de facture
                @elseif($type === 'attestation_realisation' || $type === 'attestation_signataire')
                    Date de signature
                @else
                    Date du devis
                @endif
            </label>
            <input type="date"
                   name="{{ $type === 'facture' ? 'date_facture' : 'date_devis' }}"
                   class="form-control"
                   value="{{ $document->{$type === 'facture' ? 'date_facture' : 'date_devis'} ?? '' }}"
                   {{ ro($type === 'cahier_charge') }}>
        </div>

        {{-- ======================= CHAMPS PRINCIPAUX ======================= --}}
        @php
            $fields_devis = [
                'reference_devis','adresse_travaux','numero_immatriculation','nom_residence',
                'parcelle_1','parcelle_2','parcelle_3','parcelle_4','dates_previsionnelles',
                'nombre_batiments','details_batiments'
            ];

            $fields_montants = [
                'montant_ht','montant_tva','montant_ttc','prime_cee','reste_a_charge'
            ];

            $fields_techniques = [
                'puissance_chaudiere','nombre_logements','nombre_emetteurs','zone_climatique',
                'volume_circuit','nombre_filtres','wh_cumac','somme'
            ];

            $fields_attestation = [
                'puissance_nominale','volume_total','date_travaux','details_batiment'
            ];

            $fields_rapport = [
                'reference_facture','adresse_travaux_1','boite_postale_1','adresse_travaux_2'
            ];
        @endphp

        {{-- ---------------- DEVIS ---------------- --}}
        @if($type === 'devis')
            @foreach(array_merge($fields_devis, $fields_montants, $fields_techniques) as $field)
            <div class="mb-3">
                <label>{{ ucwords(str_replace('_',' ',$field)) }}</label>
                <input type="text" name="{{ $field }}" class="form-control" value="{{ $document->$field ?? '' }}">
            </div>
            @endforeach
        @endif

        {{-- ---------------- FACTURE ---------------- --}}
        @if($type === 'facture')
            @foreach(array_merge($fields_devis, $fields_montants, $fields_techniques) as $field)
            <div class="mb-3">
                <label>{{ ucwords(str_replace('_',' ',$field)) }}</label>
                <input type="text" name="{{ $field }}" class="form-control" value="{{ $document->$field ?? '' }}" readonly>
            </div>
            @endforeach
        @endif

        {{-- ---------------- ATTESTATION DE RÉALISATION ---------------- --}}
        @if($type === 'attestation_realisation')
            @foreach(array_merge($fields_devis, $fields_attestation) as $field)
            <div class="mb-3">
                <label>{{ ucwords(str_replace('_',' ',$field)) }}</label>
                <input type="text" name="{{ $field }}" class="form-control" value="{{ $document->$field ?? '' }}" readonly>
            </div>
            @endforeach
        @endif

        {{-- ---------------- ATTESTATION SIGNATAIRE ---------------- --}}
        @if($type === 'attestation_signataire')
            @foreach(['nom_residence','adresse_travaux','numero_immatriculation'] as $field)
            <div class="mb-3">
                <label>{{ ucwords(str_replace('_',' ',$field)) }}</label>
                <input type="text" name="{{ $field }}" class="form-control" value="{{ $document->$field ?? '' }}" readonly>
            </div>
            @endforeach
        @endif

        {{-- ---------------- CAHIER DE CHARGE ---------------- --}}
        @if($type === 'cahier_charge')
            <div class="mb-3">
                <label>Prime CEE</label>
                <input type="text" name="prime_cee" class="form-control" value="{{ $document->prime_cee ?? '' }}">
            </div>
            <div class="mb-3">
                <label>Date du devis</label>
                <input type="date" class="form-control" value="{{ $document->date_devis ?? '' }}" readonly>
            </div>
        @endif

        {{-- ---------------- RAPPORT ---------------- --}}
        @if($type === 'rapport')
            @foreach(array_merge($fields_techniques, $fields_rapport) as $field)
            <div class="mb-3">
                <label>{{ ucwords(str_replace('_',' ',$field)) }}</label>
                <input type="text" name="{{ $field }}" class="form-control" value="{{ $document->$field ?? '' }}" readonly>
            </div>
            @endforeach
        @endif

        {{-- ----------------- Bouton Submit ----------------- --}}
        <button type="submit" class="btn btn-primary">
            {{ isset($document) ? 'Modifier' : 'Créer' }}
        </button>
    </form>
</div>

@endsection
