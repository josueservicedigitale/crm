@extends('back.layouts.principal')

@section('title', 'Tous les Espaces de Travail')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark">
                <i class="fa fa-project-diagram me-2 text-primary"></i>
                Tous les Espaces de Travail
            </h4>
            <p class="text-muted">Vue d'ensemble de toutes les combinaisons activité-société</p>
        </div>
    </div>

    <div class="row g-4">
        @foreach($espaces as $espace)
        <div class="col-md-6">
            <div class="bg-light rounded shadow-sm p-4 h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-bold text-dark">{{ $espace['label'] }}</h5>
                        @php
                            $docCount = \App\Models\Document::where('activity', $espace['activity'])
                                ->where('society', $espace['society'])
                                ->count();
                        @endphp
                        <p class="text-muted small">{{ $docCount }} documents</p>
                    </div>
                    <span class="badge bg-primary">
                        {{ $espace['activity'] == 'desembouage' ? '💧' : '⚖️' }}
                    </span>
                </div>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('back.dashboard', $espace) }}" 
                       class="btn btn-primary">
                        <i class="fa fa-door-open me-2"></i>Accéder à l'espace
                    </a>
                    <a href="{{ route('back.document.list', [
                        'activity' => $espace['activity'], 
                        'society' => $espace['society'],
                        'type' => 'devis'
                    ]) }}" 
                       class="btn btn-outline-primary">
                        <i class="fa fa-file-invoice me-2"></i>Voir les devis
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection