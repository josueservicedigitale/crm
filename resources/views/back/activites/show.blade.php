@extends('back.layouts.principal')

@section('title', 'Activité - ' . $nomActivite)

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark">
                        <i class="fa fa-tasks me-2 text-primary"></i>
                        {{ $nomActivite }}
                    </h4>
                    <p class="text-muted mb-0">Code: {{ $activite }}</p>
                </div>
                <div>
                    <a href="{{ route('back.activite.edit', $activite) }}" class="btn btn-outline-secondary">

                        <i class="fa fa-edit me-2"></i>Éditer
                    </a>
                    <a href="{{ route('back.activite.index') }}" class="btn btn-outline-primary">

                        <i class="fa fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Statistiques -->
        <div class="col-md-4">
            <div class="bg-white rounded shadow-sm p-4">
                <h6 class="fw-bold mb-3">Statistiques</h6>
                <div class="mb-3">
                    <p class="text-muted small mb-1">Total Documents</p>
                    <h3 class="fw-bold text-primary">{{ $stats['total_documents'] }}</h3>
                </div>
                <div class="mb-3">
                    <p class="text-muted small mb-1">Devis</p>
                    <h5 class="fw-bold">{{ $stats['devis_count'] }}</h5>
                </div>
                <div class="mb-3">
                    <p class="text-muted small mb-1">Factures</p>
                    <h5 class="fw-bold">{{ $stats['factures_count'] }}</h5>
                </div>
            </div>
        </div>

        <!-- Répartition par société -->
        <div class="col-md-4">
            <div class="bg-white rounded shadow-sm p-4">
                <h6 class="fw-bold mb-3">Par Société</h6>
                <div class="mb-3">
                    <p class="text-muted small mb-1">Énergie Nova</p>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-primary" style="width: {{ ($stats['societes']['nova'] / max($stats['total_documents'], 1)) * 100 }}%">
                            {{ $stats['societes']['nova'] }}
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <p class="text-muted small mb-1">MyHouse</p>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-success" style="width: {{ ($stats['societes']['house'] / max($stats['total_documents'], 1)) * 100 }}%">
                            {{ $stats['societes']['house'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="col-md-4">
            <div class="bg-white rounded shadow-sm p-4">
                <h6 class="fw-bold mb-3">Actions Rapides</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('back.dashboard', ['activity' => $activite, 'society' => 'nova']) }}" 
                       class="btn btn-outline-primary">
                        <i class="fa fa-building me-2"></i>Espaces Énergie Nova
                    </a>
                    <a href="{{ route('back.dashboard', ['activity' => $activite, 'society' => 'house']) }}" 
                       class="btn btn-outline-success">
                        <i class="fa fa-home me-2"></i>Espaces MyHouse
                    </a>
                    <a href="{{ route('back.document.choose', ['activity' => $activite, 'society' => 'nova', 'type' => 'devis']) }}" 
                       class="btn btn-primary">
                        <i class="fa fa-plus me-2"></i>Nouveau Document
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection