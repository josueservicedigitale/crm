@extends('back.layouts.principal')

@section('title', 'Gestion des Activités')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold text-dark">
                    <i class="fa fa-tasks me-2 text-primary"></i>
                    Activités
                </h4>
                <a href="{{ route('back.activite.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-2"></i>Nouvelle activité
                </a>
            </div>
            <p class="text-muted">Gérez vos activités métier (Désembouage, Rééquilibrage...)</p>
        </div>
    </div>

    <div class="row g-4">
        @foreach($activites as $code => $activite)
        <div class="col-md-6">
            <div class="bg-light rounded shadow-sm p-4 h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-bold text-dark">{{ $activite['nom'] }}</h5>
                        <p class="text-muted small mb-2">{{ $activite['description'] }}</p>
                    </div>
                    <span class="badge bg-primary">{{ $activite['documents_count'] }} docs</span>
                </div>
                
                <div class="row mb-3">
                    <div class="col-6">
                        <small class="text-muted">Code</small>
                        <p class="fw-bold">{{ $code }}</p>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Créée le</small>
                        <p class="fw-bold">{{ $activite['created_at'] }}</p>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('back.activite.show', $code) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-eye me-1"></i>Voir
                    </a>
                    <a href="{{ route('back.activite.edit', $code) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-edit me-1"></i>Éditer
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection