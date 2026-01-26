@extends('back.layouts.principal')

@section('title', ucfirst($type) . ' - ' . strtoupper($society))

@section('content')


<div class="alert alert-info">
    <h5>Debug Info:</h5>
    <ul>
        <li>Type: {{ $type }}</li>
        <li>Activity: {{ $activity }}</li>
        <li>Society: {{ $society }}</li>
        <li>Document exists: {{ isset($document) ? 'Yes' : 'No' }}</li>
        <li>Parent exists: {{ isset($parent) ? 'Yes' : 'No' }}</li>
        <li>Route:
            @if(isset($document) && $document->id)
                {{ route('back.document.update', [$activity, $society, $type, $document->id]) }}
            @else
                {{ route('back.document.store', [$activity, $society, $type]) }}
            @endif
        </li>
    </ul>
</div>

@section('content')
<div class="alert alert-danger">
    <h5>Debug URL:</h5>
    <ul>
        <li>URL complète: {{ url()->full() }}</li>
        <li>Parent ID from URL: {{ request('parent_id') ?? 'Non fourni' }}</li>
        <li>Parent exists: {{ isset($parent) && $parent ? 'Oui (ID: ' . $parent->id . ')' : 'Non' }}</li>
        <li>Document exists: {{ isset($document) && $document->id ? 'Oui' : 'Non' }}</li>
    </ul>
</div>

@if(!isset($parent) && in_array($type, ['facture', 'attestation_realisation', 'attestation_signataire', 'cahier_des_charges']))
<div class="alert alert-warning">
    <h5>Attention !</h5>
    <p>Aucun devis n'a été sélectionné pour créer ce document.</p>
    <a href="{{ route('back.document.select-devis', [$activity, $society, $type]) }}" 
       class="btn btn-warning">
        Sélectionner un devis
    </a>
</div>
@endif

{{-- Le reste de votre code... --}}



<div class="container-fluid pt-4 px-4">

    <h4 class="fw-bold text-dark mb-4">
        <i class="fa fa-file-alt me-2"></i>
        {{ strtoupper($society) }} – {{ ucfirst($activity) }} – {{ strtoupper($type) }}
    </h4>

   <form method="POST"
      action="{{ isset($document) && $document->id
        ? route('back.document.update', [$activity, $society, $type, $document->id])
        : route('back.document.store', [$activity, $society, $type]) }}"
      class="needs-validation"
      novalidate>

        @csrf
        @if(isset($document) && $document->id && $type !== 'rapport')
            @method('PUT')
        @endif


        
    @if($type === 'devis')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fa fa-file-alt me-2"></i> Informations du document
        </h5>
    </div>

    <div class="card-body row">

        {{-- IDENTIFICATION --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Référence devis</label>
            <input type="text" name="reference_devis" class="form-control"
                   value="{{ old('reference_devis', $document->reference_devis ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Date du devis</label>
            <input type="date" name="date_devis" class="form-control"
                   value="{{ old('date_devis', $document->date_devis ?? '') }}">
        </div>

        {{-- LOCALISATION --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Adresse des travaux</label>
            <input type="text" name="adresse_travaux" class="form-control"
                   value="{{ old('adresse_travaux', $document->adresse_travaux ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Numéro d’immatriculation</label>
            <input type="text" name="numero_immatriculation" class="form-control"
                   value="{{ old('numero_immatriculation', $document->numero_immatriculation ?? '') }}">
        </div>

        {{-- BÂTIMENT --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Nom de la résidence</label>
            <input type="text" name="nom_residence" class="form-control"
                   value="{{ old('nom_residence', $document->nom_residence ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre de bâtiments</label>
            <input type="number" name="nombre_batiments" class="form-control"
                   value="{{ old('nombre_batiments', $document->nombre_batiments ?? '') }}">
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Description du projet / bâtiments</label>
            <textarea name="details_batiments" rows="3" class="form-control">{{ old('details_batiments', $document->details_batiments ?? '') }}</textarea>
        </div>

        {{-- PARCELLES --}}
        <div class="col-md-3 mb-3">
            <label class="form-label">Parcelle 1</label>
            <input type="text" name="parcelle_1" class="form-control"
                   value="{{ old('parcelle_1', $document->parcelle_1 ?? '') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Parcelle 2</label>
            <input type="text" name="parcelle_2" class="form-control"
                   value="{{ old('parcelle_2', $document->parcelle_2 ?? '') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Parcelle 3</label>
            <input type="text" name="parcelle_3" class="form-control"
                   value="{{ old('parcelle_3', $document->parcelle_3 ?? '') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Parcelle 4</label>
            <input type="text" name="parcelle_4" class="form-control"
                   value="{{ old('parcelle_4', $document->parcelle_4 ?? '') }}">
        </div>

        {{-- DATES --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Dates prévisionnelles</label>
            <input type="text" name="dates_previsionnelles" class="form-control"
                   value="{{ old('dates_previsionnelles', $document->dates_previsionnelles ?? '') }}">
        </div>

        {{-- MONTANTS --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Montant HT</label>
            <input type="number" step="0.01" name="montant_ht" class="form-control"
                   value="{{ old('montant_ht', $document->montant_ht ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">TVA</label>
            <input type="number" step="0.01" name="montant_tva" class="form-control"
                   value="{{ old('montant_tva', $document->montant_tva ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Montant TTC</label>
            <input type="number" step="0.01" name="montant_ttc" class="form-control"
                   value="{{ old('montant_ttc', $document->montant_ttc ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Prime CEE</label>
            <input type="number" step="0.01" name="prime_cee" class="form-control"
                   value="{{ old('prime_cee', $document->prime_cee ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Reste à charge</label>
            <input type="number" step="0.01" name="reste_a_charge" class="form-control"
                   value="{{ old('reste_a_charge', $document->reste_a_charge ?? '') }}">
        </div>

        {{-- INFORMATIONS TECHNIQUES --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Puissance chaudière</label>
            <input type="text" name="puissance_chaudiere" class="form-control"
                   value="{{ old('puissance_chaudiere', $document->puissance_chaudiere ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre de logements</label>
            <input type="number" name="nombre_logements" class="form-control"
                   value="{{ old('nombre_logements', $document->nombre_logements ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre d’émetteurs</label>
            <input type="number" name="nombre_emetteurs" class="form-control"
                   value="{{ old('nombre_emetteurs', $document->nombre_emetteurs ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Zone climatique</label>
            <input type="text" name="zone_climatique" class="form-control"
                   value="{{ old('zone_climatique', $document->zone_climatique ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Volume circuit</label>
            <input type="text" name="volume_circuit" class="form-control"
                   value="{{ old('volume_circuit', $document->volume_circuit ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre filtres</label>
            <input type="number" name="nombre_filtres" class="form-control"
                   value="{{ old('nombre_filtres', $document->nombre_filtres ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">WH Cumac</label>
            <input type="text" name="wh_cumac" class="form-control"
                   value="{{ old('wh_cumac', $document->wh_cumac ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Somme</label>
            <input type="number" step="0.01" name="somme" class="form-control"
                   value="{{ old('somme', $document->somme ?? '') }}">
        </div>

    </div>
</div>


@endif
@if($type === 'facture' && isset($parent))
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="fa fa-file-invoice me-2"></i> Informations Facture
        </h5>
    </div>

    <div class="card-body row">

        {{-- Liaison avec le devis --}}
        <input type="hidden" name="parent_id" value="{{ $parent->id }}">

        {{-- Copier TOUTES les données du devis --}}
        @foreach($parent->getAttributes() as $key => $value)
            @if(!in_array($key, [
                'id',
                'reference',
                'type',
                'parent_id',
                'created_at',
                'updated_at',
                'file_path'
            ]))
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach

        {{-- Champ visible à remplir --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Date de la facture</label>
            <input type="date"
                   name="date_facture"
                   class="form-control"
                   value="{{ old('date_facture', $document->date_facture ?? '') }}"
                   required>
        </div>

        {{-- Champ pour la référence de la facture --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Référence facture</label>
            <input type="text"
                   name="reference_facture"
                   class="form-control"
                   value="{{ old('reference_facture', $document->reference_facture ?? '') }}">
        </div>

    </div>
</div>
@endif




@if($type === 'attestation_realisation' && isset($parent))

{{-- liaison avec le devis --}}
<input type="hidden" name="parent_id" value="{{ $parent->id }}">

{{-- copier TOUTES les données du devis --}}
@foreach($parent->getAttributes() as $key => $value)
    @if(!in_array($key, [
        'id',
        'reference',
        'type',
        'parent_id',
        'created_at',
        'updated_at',
        'file_path'
    ]))
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endif
        @endforeach

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fa fa-check-circle me-2"></i>
                    Attestation de réalisation
                </h5>
            </div>

            <div class="card-body row">

                {{-- champs visibles mais non modifiables --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Référence devis</label>
                    <input type="text" class="form-control"
                        value="{{ $parent->reference_devis }}"
                        readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Adresse des travaux</label>
                    <input type="text" class="form-control"
                        value="{{ $parent->adresse_travaux }}"
                        readonly>
                </div>

                {{-- SEUL champ éditable --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date de signature</label>
                    <input type="date"
                        name="date_signature"
                        class="form-control"
                        required>
                </div>

            </div>
        </div>
        @endif

        @if($type === 'attestation_signataire' && isset($parent))

                {{-- Liaison avec le devis --}}
                <input type="hidden" name="parent_id" value="{{ $parent->id }}">

                {{-- Copier TOUTES les données du devis (silencieux) --}}
                @foreach($parent->getAttributes() as $key => $value)
                    @if(!in_array($key, [
                        'id',
                        'reference',
                        'type',
                        'parent_id',
                        'created_at',
                        'updated_at',
                        'file_path'
                    ]))
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fa fa-signature me-2"></i>
                            Attestation signataire
                        </h5>
                    </div>

                    <div class="card-body row">

                        {{-- Champs affichés en lecture seule --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Référence devis</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $parent->reference_devis }}"
                                readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom de la résidence</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $parent->nom_residence }}"
                                readonly>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Adresse des travaux</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $parent->adresse_travaux }}"
                                readonly>
                        </div>

                        {{-- SEUL champ éditable --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de signature</label>
                            <input type="date"
                                name="date_signature"
                                class="form-control"
                                value="{{ old('date_signature', $document->date_signature ?? '') }}"
                                required>
                        </div>

                    </div>
                </div>
            @endif


        @if($type === 'cahier_des_charges' && isset($parent))

                {{-- Liaison avec le devis --}}
                <input type="hidden" name="parent_id" value="{{ $parent->id }}">

                {{-- Copier TOUTES les données du devis (silencieux) --}}
                @foreach($parent->getAttributes() as $key => $value)
                    @if(!in_array($key, [
                        'id',
                        'reference',
                        'type',
                        'parent_id',
                        'created_at',
                        'updated_at',
                        'file_path'
                    ]))
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fa fa-cahier me-2"></i>
                            cahier_des_charges
                        </h5>
                    </div>

                    <div class="card-body row">

                        {{-- Champs affichés en lecture seule --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Référence devis</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $parent->reference_devis }}"
                                readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom de la résidence</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $parent->nom_residence }}"
                                readonly>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Adresse des travaux</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $parent->adresse_travaux }}"
                                readonly>
                        </div>

                        {{-- SEUL champ éditable --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de signature</label>
                            <input type="date"
                                name="date_signature"
                                class="form-control"
                                value="{{ old('date_signature', $document->date_signature ?? '') }}"
                                required>
                        </div>

                    </div>
                </div>
            @endif


            @if($type === 'rapport' && isset($parent))
    {{-- Liaison avec la facture --}}
    <input type="hidden" name="parent_id" value="{{ $parent->id }}">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fa fa-file-pdf me-2"></i>
                Rapport
            </h5>
        </div>

        <div class="card-body row">

            {{-- Référence facture ou référence devis si facture absente --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Référence</label>
                <input type="text" class="form-control" readonly
                       value="{{ $parent->reference_facture ?? $parent->reference_devis ?? $parent->reference }}">
            </div>

            {{-- Nom de la résidence --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Nom de la résidence</label>
                <input type="text" class="form-control" readonly
                       value="{{ $parent->nom_residence }}">
            </div>

            {{-- Adresse des travaux --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">Adresse des travaux</label>
                <input type="text" class="form-control" readonly
                       value="{{ $parent->adresse_travaux }}">
            </div>

            {{-- Date de la facture --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Date de la facture</label>
                <input type="date" class="form-control" readonly
                       value="{{ $parent->date_facture ?? '' }}">
            </div>

            {{-- Volume circuit --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Volume circuit</label>
                <input type="text" class="form-control" readonly
                       value="{{ $parent->volume_circuit ?? '' }}">
            </div>

            {{-- Puissance chaudière --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Puissance chaudière</label>
                <input type="text" class="form-control" readonly
                       value="{{ $parent->puissance_chaudiere ?? '' }}">
            </div>

            {{-- Nombre d’émetteurs --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre d’émetteurs</label>
                <input type="number" class="form-control" readonly
                       value="{{ $parent->nombre_emetteurs ?? '' }}">
                </div>

            </div>
        </div>
    @endif



<div class="mb-4 d-flex justify-content-between">
    <a href="{{ route('home.dashboard') }}" class="btn btn-secondary btn-lg">
        Retour
    </a>
   <button type="submit" class="btn btn-primary btn-lg">
    Créer le {{ str_replace('_', ' ', $type) }}
</button>


</div>
    </form>
</div>
@endsection
