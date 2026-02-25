@extends('back.layouts.principal')

@section('title', 'Mes dossiers')

@section('content')
<div class="container-fluid pt-4 px-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded shadow-sm p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold mb-2">
                            <i class="fas fa-folder-open me-2 text-primary"></i>
                            Mes dossiers
                        </h4>
                        <p class="text-muted mb-0">
                            Gérez vos documents et dossiers personnels
                        </p>
                    </div>
                    <a href="{{ route('back.dossiers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nouveau dossier
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-white rounded shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-md rounded-circle bg-primary bg-opacity-10">
                            <i class="fas fa-folder text-primary"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total dossiers</h6>
                        <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-white rounded shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-md rounded-circle bg-success bg-opacity-10">
                            <i class="fas fa-globe text-success"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Publics</h6>
                        <h4 class="fw-bold mb-0">{{ $stats['publics'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-white rounded shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-md rounded-circle bg-warning bg-opacity-10">
                            <i class="fas fa-lock text-warning"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Privés</h6>
                        <h4 class="fw-bold mb-0">{{ $stats['prives'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-white rounded shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-md rounded-circle bg-info bg-opacity-10">
                            <i class="fas fa-database text-info"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Stockage</h6>
                        <h4 class="fw-bold mb-0">{{ formatBytes($stats['taille_totale']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded shadow-sm p-4">
                <form method="GET" action="{{ route('back.dossiers.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Recherche</label>
                        <input type="text" name="search" class="form-control"
                            placeholder="Nom du dossier..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Société</label>
                        <select name="societe" class="form-select">
                            <option value="">Toutes</option>
                            @foreach($societes as $societe)
                            <option value="{{ $societe->id }}" {{ request('societe') == $societe->id ? 'selected' : '' }}>
                                {{ $societe->nom }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Activité</label>
                        <select name="activite" class="form-select">
                            <option value="">Toutes</option>
                            @foreach($activites as $activite)
                            <option value="{{ $activite->id }}" {{ request('activite') == $activite->id ? 'selected' : '' }}>
                                {{ $activite->nom }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Visibilité</label>
                        <select name="visibilite" class="form-select">
                            <option value="">Tous</option>
                            <option value="public" {{ request('visibilite') == 'public' ? 'selected' : '' }}>Publics</option>
                            <option value="prive" {{ request('visibilite') == 'prive' ? 'selected' : '' }}>Privés</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-2"></i>Filtrer
                        </button>
                        <a href="{{ route('back.dossiers.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-2"></i>Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Liste des dossiers -->
    <div class="row g-4">
        @forelse($dossiers as $dossier)
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100 dossier-card" data-id="{{ $dossier->id }}">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-xl rounded-circle d-flex align-items-center justify-content-center"
                                style="
                                    --dossier-color: {{ $dossier->couleur }};
                                    background-color: var(--dossier-color)20;
                                    width: 80px;
                                    height: 80px;
                                ">
                                <i class="fas {{ $dossier->icone_classe }} fa-3x"
                                    style="color: var(--dossier-color);">
                                </i>

                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-1">
                                <a href="{{ route('back.dossiers.show', $dossier->slug) }}"
                                    class="text-decoration-none text-dark">
                                    {{ $dossier->nom }}
                                </a>
                            </h5>
                            <p class="small text-muted mb-2">{{ $dossier->chemin_complet }}</p>
                            <div>
                                @if($dossier->societe)
                                <span class="badge bg-primary bg-opacity-10 text-primary me-1">
                                    <i class="fas fa-building me-1"></i>{{ $dossier->societe->nom }}
                                </span>
                                @endif
                                @if($dossier->activite)
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-tasks me-1"></i>{{ $dossier->activite->nom }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="small text-muted">
                            <i class="fas fa-folder me-1"></i>{{ $dossier->enfants_count }} sous-dossiers
                        </div>
                        <div class="small text-muted">
                            <i class="fas fa-file me-1"></i>{{ $dossier->fichiers_count }} fichiers
                        </div>
                        <div class="small text-muted">
                            <i class="fas fa-weight me-1"></i>{{ $dossier->taille_formatee }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if($dossier->est_visible)
                            <span class="badge bg-success" data-bs-toggle="tooltip" title="Dossier public">
                                <i class="fas fa-globe me-1"></i>Public
                            </span>
                            @else
                            <span class="badge bg-warning" data-bs-toggle="tooltip" title="Dossier privé">
                                <i class="fas fa-lock me-1"></i>Privé
                            </span>
                            @endif
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('back.dossiers.show', $dossier->slug) }}"
                                class="btn btn-sm btn-outline-primary"
                                data-bs-toggle="tooltip" title="Ouvrir">
                                <i class="fas fa-folder-open"></i>
                            </a>
                            @if($dossier->user_id == auth()->id())
                            <a href="{{ route('back.dossiers.edit', $dossier->id) }}"
                                class="btn btn-sm btn-outline-warning"
                                data-bs-toggle="tooltip" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button"
                                class="btn btn-sm btn-outline-{{ $dossier->est_visible ? 'warning' : 'success' }} toggle-visibilite"
                                data-id="{{ $dossier->id }}"
                                data-visible="{{ $dossier->est_visible }}"
                                data-bs-toggle="tooltip"
                                title="{{ $dossier->est_visible ? 'Rendre privé' : 'Rendre public' }}">
                                <i class="fas fa-{{ $dossier->est_visible ? 'lock' : 'globe' }}"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun dossier trouvé</h5>
                    <p class="text-muted mb-4">Créez votre premier dossier pour organiser vos documents</p>
                    <a href="{{ route('back.dossiers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nouveau dossier
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $dossiers->withQueryString()->links() }}
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Toggle visibilité
        $('.toggle-visibilite').click(function() {
            const btn = $(this);
            const dossierId = btn.data('id');
            const etaitVisible = btn.data('visible');

            $.ajax({
                url: `/back/dossiers/${dossierId}/toggle-visibilite`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Recharger la page ou mettre à jour l'UI
                        location.reload();
                    }
                },
                error: function(xhr) {
                    alert('Erreur: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endpush