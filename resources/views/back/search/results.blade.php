@extends('back.layouts.principal')

@section('title', 'Résultats de recherche : ' . $query)

@section('content')
<div class="container-fluid pt-4 px-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded shadow-sm p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold mb-2">
                            <i class="fas fa-search me-2 text-primary"></i>
                            Résultats pour "{{ $query }}"
                        </h4>
                        <p class="text-muted mb-0">
                            {{ $stats['total'] }} résultat(s) trouvé(s)
                        </p>
                    </div>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-md-2 col-6">
            <div class="bg-primary bg-opacity-10 rounded p-3 text-center">
                <h5 class="fw-bold text-white mb-0">{{ $stats['documents'] }}</h5>
                <small class="text-white">Documents</small>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="bg-success bg-opacity-10 rounded p-3 text-center">
                <h5 class="fw-bold text-white mb-0">{{ $stats['societes'] }}</h5>
                <small class="text-white">Sociétés</small>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="bg-warning bg-opacity-10 rounded p-3 text-center">
                <h5 class="fw-bold text-white mb-0">{{ $stats['activites'] }}</h5>
                <small class="text-white">Activités</small>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="bg-info bg-opacity-10 rounded p-3 text-center">
                <h5 class="fw-bold text-white mb-0">{{ $stats['users'] }}</h5>
                <small class="text-white">Utilisateurs</small>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="bg-secondary bg-opacity-10 rounded p-3 text-center">
                <h5 class="fw-bold text-white mb-0">{{ $stats['messages'] }}</h5>
                <small class="text-white">Messages</small>
            </div>
        </div>
    </div>

    <!-- Résultats détaillés -->
    <div class="row">
        <!-- Documents -->
        @if($documents->count() > 0)
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-file-alt me-2 text-primary"></i>
                        Documents ({{ $documents->count() }})
                    </h6>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($documents as $doc)
                    <a href="{{ $doc['url'] }}" class="list-group-item list-group-item-action p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-md rounded-circle bg-{{ $doc['color'] }} bg-opacity-10 d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px;">
                                    <i class="fas {{ $doc['icon'] }} fa-lg text-{{ $doc['color'] }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-1 fw-bold">{{ $doc['title'] }}</h6>
                                    <small class="text-muted">{{ $doc['date'] }}</small>
                                </div>
                                <p class="mb-1 text-muted small">{{ $doc['subtitle'] }}</p>
                                <span class="badge bg-{{ $doc['color'] }} bg-opacity-10 text-{{ $doc['color'] }}">
                                    {{ $doc['type_label'] }}
                                </span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary ms-2">
                                    {{ $doc['badge'] }}
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Sociétés -->
        @if($societes->count() > 0)
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-building me-2 text-primary"></i>
                        Sociétés ({{ $societes->count() }})
                    </h6>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($societes as $soc)
                    <a href="{{ $soc['url'] }}" class="list-group-item list-group-item-action p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-md rounded-circle bg-{{ $soc['color'] }} bg-opacity-10 d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px;">
                                    <i class="fas {{ $soc['icon'] }} fa-lg text-{{ $soc['color'] }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">{{ $soc['title'] }}</h6>
                                <p class="mb-1 text-muted small">{{ $soc['subtitle'] }}</p>
                                <span class="badge bg-{{ $soc['color'] }}">{{ $soc['badge'] }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Activités -->
        @if($activites->count() > 0)
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-tasks me-2 text-primary"></i>
                        Activités ({{ $activites->count() }})
                    </h6>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($activites as $act)
                    <a href="{{ $act['url'] }}" class="list-group-item list-group-item-action p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-md rounded-circle bg-{{ $act['color'] }} bg-opacity-10 d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px;">
                                    <i class="fas {{ $act['icon'] }} fa-lg text-{{ $act['color'] }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">{{ $act['title'] }}</h6>
                                <p class="mb-1 text-muted small">{{ $act['subtitle'] }}</p>
                                <span class="badge bg-{{ $act['color'] }}">{{ $act['badge'] }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Utilisateurs -->
        @if($users->count() > 0)
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-users me-2 text-primary"></i>
                        Utilisateurs ({{ $users->count() }})
                    </h6>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($users as $user)
                    <a href="{{ $user['url'] }}" class="list-group-item list-group-item-action p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-md rounded-circle bg-{{ $user['color'] }} bg-opacity-10 d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px;">
                                    <i class="fas {{ $user['icon'] }} fa-lg text-{{ $user['color'] }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">{{ $user['title'] }}</h6>
                                <p class="mb-1 text-muted small">{{ $user['subtitle'] }}</p>
                                <span class="badge bg-{{ $user['badge'] == 'Actif' ? 'success' : 'secondary' }}">
                                    {{ $user['badge'] }}
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Messages -->
        @if($messages->count() > 0)
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-comments me-2 text-primary"></i>
                        Messages ({{ $messages->count() }})
                    </h6>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($messages as $msg)
                    <a href="{{ $msg['url'] }}" class="list-group-item list-group-item-action p-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-md rounded-circle bg-{{ $msg['color'] }} bg-opacity-10 d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px;">
                                    <i class="fas {{ $msg['icon'] }} fa-lg text-{{ $msg['color'] }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1 fw-bold small">{{ $msg['title'] }}</h6>
                                    <small class="text-muted">{{ $msg['date'] }}</small>
                                </div>
                                <p class="mb-0 text-muted small">{{ $msg['subtitle'] }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($stats['total'] == 0)
        <div class="col-12">
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                    <h5 class="text-muted">Aucun résultat trouvé</h5>
                    <p class="text-muted mb-4">Essayez avec d'autres mots-clés</p>
                    <a href="{{ url()->previous() }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection