@extends('back.layouts.principal')

@section('title', 'MYHOUSE - Dashboard')

@section('content')

<div class="container-fluid pt-4 px-4">

    <!-- Titre spécifique à la société sélectionnée -->
    <div class="row mb-4">
        <div class="col-12 text-center text-md-start">
            <h4 class="fw-bold text-dark">
                <i class="fa fa-building me-2 text-success"></i>
                Bienvenu sur le Désembouage – Myhouse {{ auth()->user()->name }}
                

            </h4>
            <p class="text-muted mb-0">
                Gestion des documents pour la société <span class="fw-semibold text-success">Myhouse</span>.  
                Sélectionnez le type de document à créer ou gérer ci-dessous.
            </p>
        </div>
    </div>

    <!-- Cartes Documents -->
    <div class="row g-4">

        @php
            $documents = [
                ['title'=>'Devis','icon'=>'fa-file-invoice-dollar','desc'=>'Création et suivi des devis clients','type'=>'devis'],
                ['title'=>'Facture','icon'=>'fa-file-invoice','desc'=>'Génération et gestion des factures','type'=>'facture'],
                ['title'=>'Attestation de réalisation','icon'=>'fa-check-circle','desc'=>'Validation officielle des travaux','type'=>'attestation_realisation'],
                ['title'=>'Attestation signataire','icon'=>'fa-user-check','desc'=>'Documents de responsabilité et signature','type'=>'attestation_signataire'],
                ['title'=>'Rapport','icon'=>'fa-chart-line','desc'=>'Analyse et rapports techniques','type'=>'rapport'],
                ['title'=>'Cahier des charges','icon'=>'fa-book','desc'=>'Définition et structuration des projets','type'=>'cahier_des_charges'],
            ];
        @endphp

        @foreach($documents as $doc)
            <div class="col-sm-6 col-xl-4">
                <a href="{{ route('back.document.choose', [
                    'activity' => $activity,
                    'society'  => $society,
                    'type'     => $doc['type']
                ]) }}" class="text-decoration-none">
                <div class="bg-light rounded shadow-sm h-100 card-hover d-flex flex-column justify-content-between p-4 transition-hover">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <i class="fa {{ $doc['icon'] }} fa-3x" style="color: #28a745;"></i>
                        <span class="badge rounded-pill" style="background: linear-gradient(135deg, #28a745, #a2f5a2); color: #fff;">
                            {{ $doc['title'] }}
                        </span>
                    </div>
                    <h6 class="mb-1 fw-bold text-dark">{{ $doc['title'] }}</h6>
                    <p class="text-muted small mb-0">{{ $doc['desc'] }}</p>
                </div>
            </a>
        </div>
        @endforeach

    </div>
</div>

@endsection
