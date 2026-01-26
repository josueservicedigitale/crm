@extends('back.layouts.principal')

@section('title', ucfirst($type) . ' - ' . strtoupper($society))

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="fw-bold text-dark">
        <i class="fa fa-file-alt me-2"></i>
        {{ strtoupper($society) }} – {{ ucfirst($activity) }} – {{ ucfirst($type) }}
    </h4>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <i class="fa fa-plus-circle fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Créer un nouveau document</h5>
                    <p class="card-text">Créer un nouveau {{ $type }}.</p>

                   <div class="mt-auto">
                        @if(in_array($type, [
                            'facture',
                            'attestation_realisation',
                            'attestation_signataire',
                            'cahier_des_charges',
                            'rapport'
                        ]))
                            {{-- POUR 'rapport' : route spéciale --}}
                            @if($type === 'rapport')
                                <a href="{{ route('back.document.select-facture-for-rapport', [$activity, $society]) }}"
                                class="btn btn-primary btn-lg w-100">
                                    Créer un rapport
                                </a>
                            
                            {{-- POUR 'cahier_des_charges' : utilise select-devis normal --}}
                            @else
                                <a href="{{ route('back.document.select-devis', [$activity, $society, $type]) }}"
                                class="btn btn-primary btn-lg w-100">
                                    Créer {{ str_replace('_', ' ', $type) }}
                                </a>
                            @endif
                        
                        {{-- POUR les autres types (devis, etc.) --}}
                        @else
                            <a href="{{ route('back.document.create', [$activity, $society, $type]) }}"
                            class="btn btn-primary btn-lg w-100">
                                Créer
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <i class="fa fa-edit fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Modifier un document existant</h5>
                    <p class="card-text">Modifier un {{ $type }} déjà créé.</p>

                    <div class="mt-auto">
                        <a href="{{ route('back.document.list', [$activity, $society, $type]) }}"
                           class="btn btn-warning btn-lg w-100">
                            Modifier
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('back.dashboard', [$activity, $society]) }}"
           class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Retour au dashboard
        </a>
    </div>
</div>



 

@endsection   


