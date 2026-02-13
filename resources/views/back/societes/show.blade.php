@extends('back.layouts.principal')

@section('title', 'Société - ' . $nomSociete)

@section('content')
<div class="container-fluid pt-4 px-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded shadow-sm p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        @if($societeModel->logo_url)
                        <div class="avatar avatar-xl rounded-circle"
                             style="background-color: {{ $societeModel->couleur ?? '#3B82F6' }};">
                            <img src="{{ $societeModel->logo_url }}" 
                                 alt="{{ $nomSociete }}" 
                                 class="rounded-circle"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        @else
                        <div class="avatar avatar-xl rounded-circle d-flex align-items-center justify-content-center"
                             style="background-color: {{ $societeModel->couleur ?? '#3B82F6' }}; width: 80px; height: 80px;">
                            <i class="{{ $societeModel->icon ?? 'fa-building' }} fa-2x text-white"></i>
                        </div>
                        @endif
                        <div>
                            <h4 class="fw-bold mb-1">{{ $nomSociete }}</h4>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-dark">{{ $societe }}</span>
                                @if($societeModel->est_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-toggle-on me-1"></i>Active
                                </span>
                                @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-toggle-off me-1"></i>Inactive
                                </span>
                                @endif
                            </div>
                            @if($societeModel->adresse_complete)
                            <p class="text-muted mb-0 mt-2">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $societeModel->adresse_complete }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('back.societes.edit', $societe) }}" 
                           class="btn btn-outline-primary btn-action" 
                           data-bs-toggle="tooltip" 
                           title="Modifier la société">
                            <i class="fas fa-edit me-1"></i>Éditer
                        </a>
                        <a href="{{ route('back.societes.index') }}" 
                           class="btn btn-outline-secondary btn-action"
                           data-bs-toggle="tooltip"
                           title="Retour à la liste">
                            <i class="fas fa-arrow-left me-1"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="row g-4">
        <!-- Carte informations -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h6 class="card-title mb-3 fw-bold">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informations
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Coordonnées -->
                    @if($societeModel->telephone || $societeModel->email)
                    <div class="mb-4">
                        <h6 class="text-muted small text-uppercase mb-2">Coordonnées</h6>
                        <div class="d-flex flex-column gap-2">
                            @if($societeModel->telephone)
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-phone text-primary" style="width: 20px;"></i>
                                <span>{{ $societeModel->telephone }}</span>
                            </div>
                            @endif
                            @if($societeModel->email)
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-envelope text-primary" style="width: 20px;"></i>
                                <a href="mailto:{{ $societeModel->email }}" class="text-decoration-none">
                                    {{ $societeModel->email }}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Informations légales -->
                    @if($societeModel->siret || $societeModel->tva_intracommunautaire)
                    <div class="mb-4">
                        <h6 class="text-muted small text-uppercase mb-2">Informations légales</h6>
                        <div class="d-flex flex-column gap-2">
                            @if($societeModel->siret)
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-id-card text-primary" style="width: 20px;"></i>
                                <span>SIRET: {{ $societeModel->siret }}</span>
                            </div>
                            @endif
                            @if($societeModel->tva_intracommunautaire)
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-receipt text-primary" style="width: 20px;"></i>
                                <span>TVA: {{ $societeModel->tva_intracommunautaire }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Métadonnées -->
                    <div>
                        <h6 class="text-muted small text-uppercase mb-2">Métadonnées</h6>
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-user text-primary" style="width: 20px;"></i>
                                <span>Créé par: {{ $societeModel->user->name ?? 'Inconnu' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-calendar text-primary" style="width: 20px;"></i>
                                <span>Créé le: {{ $societeModel->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte statistiques -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h6 class="card-title mb-3 fw-bold">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        Statistiques
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Total documents -->
                    <div class="text-center mb-4">
                        <div class="stat-card bg-primary bg-opacity-10 rounded-3 p-3">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                            </div>
                            <h2 class="fw-bold text-primary mb-0">{{ $stats['total'] ?? 0 }}</h2>
                            <p class="text-muted mb-0">Total Documents</p>
                        </div>
                    </div>

                    <!-- Répartition par type -->
                    <div class="mb-4">
                        <h6 class="text-muted small text-uppercase mb-2">Par Type</h6>
                        <div class="d-flex flex-column gap-2">
                            @foreach(['devis', 'facture', 'rapport', 'cahier_des_charges'] as $type)
                            @if(isset($stats[$type]) && $stats[$type] > 0)
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="type-badge type-{{ $type }} rounded-circle"
                                         style="width: 10px; height: 10px;"></div>
                                    <span class="text-capitalize">{{ str_replace('_', ' ', $type) }}</span>
                                </div>
                                <span class="badge bg-light text-dark">{{ $stats[$type] }}</span>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Répartition par activité -->
                    <div>
                        <h6 class="text-muted small text-uppercase mb-2">Par Activité</h6>
                        <div class="d-flex flex-column gap-2">
                            @foreach(['desembouage', 'reequilibrage'] as $activite)
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-tasks text-primary" style="width: 20px;"></i>
                                    <span class="text-capitalize">{{ $activite }}</span>
                                </div>
                                <span class="badge bg-light text-dark">{{ $stats[$activite] ?? 0 }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte actions rapides -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h6 class="card-title mb-3 fw-bold">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        Actions Rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <!-- Navigation vers les espaces activité -->
                        @foreach(['desembouage', 'reequilibrage'] as $activite)
                        <a href="{{ route('back.dashboard', ['activity' => $activite, 'society' => $societe]) }}"
                           class="btn btn-outline-primary btn-hover d-flex align-items-center justify-content-between">
                            <span>
                                <i class="fas fa-tasks me-2"></i>
                                Espace {{ ucfirst($activite) }}
                            </span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        @endforeach

                        <!-- Nouveau document -->
                        <div class="dropdown">
                            <button class="btn btn-primary btn-hover w-100 dropdown-toggle d-flex align-items-center justify-content-center"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="fas fa-plus me-2"></i>
                                Nouveau Document
                            </button>
                            <ul class="dropdown-menu w-100">
                                @foreach(['devis', 'facture', 'rapport', 'cahier_des_charges'] as $type)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between"
                                       href="{{ route('back.document.choose', ['activity' => 'desembouage', 'society' => $societe, 'type' => $type]) }}">
                                        <span>
                                            <i class="fas fa-file-{{ $type === 'devis' ? 'clipboard' : ($type === 'facture' ? 'invoice-dollar' : 'file-alt') }} me-2"></i>
                                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                                        </span>
                                        <i class="fas fa-arrow-right text-muted"></i>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Voir tous les documents -->
                        <a href="{{ route('back.societes.documents', $societe) }}"
                           class="btn btn-outline-secondary btn-hover d-flex align-items-center justify-content-between">
                            <span>
                                <i class="fas fa-list me-2"></i>
                                Voir tous les documents
                            </span>
                            <i class="fas fa-arrow-right"></i>
                        </a>

                        <!-- Statistiques détaillées -->
                        <a href="{{ route('back.societes.stats', $societe) }}"
                           class="btn btn-outline-info btn-hover d-flex align-items-center justify-content-between">
                            <span>
                                <i class="fas fa-chart-pie me-2"></i>
                                Statistiques détaillées
                            </span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents récents -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="card-title fw-bold mb-0">
                                <i class="fas fa-history me-2 text-primary"></i>
                                Documents Récents
                            </h6>
                            <p class="text-muted small mb-0">{{ $documentsRecents->count() }} documents</p>
                        </div>
                        <a href="{{ route('back.societes.documents', $societe) }}" 
                           class="btn btn-outline-primary btn-sm">
                            Voir tout <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($documentsRecents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" style="width: 50px;">Type</th>
                                    <th>Référence</th>
                                    <th>Activité</th>
                                    <th>Client / Adresse</th>
                                    <th>Date</th>
                                    <th>Créé par</th>
                                    <th class="text-end pe-4" style="width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentsRecents as $document)
                                <tr class="border-bottom">
                                    <td class="ps-4">
                                        <span class="badge type-{{ $document->type }}">
                                            {{ strtoupper(substr($document->type, 0, 1)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $document->numero }}</strong>
                                            @if($document->reference_devis)
                                            <br>
                                            <small class="text-muted">Devis: {{ $document->reference_devis }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $document->activity }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $document->client_nom ?? 'N/A' }}</strong>
                                            @if($document->adresse_travaux)
                                            <br>
                                            <small class="text-muted">{{ $document->adresse_travaux }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted small">
                                            <div>{{ $document->date ? $document->date->format('d/m/Y') : $document->created_at->format('d/m/Y') }}</div>
                                            <div class="text-muted">{{ $document->created_at->format('H:i') }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar avatar-xs">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <span>{{ $document->user->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('back.document.show', ['activity' => $document->activity, 'society' => $document->society, 'type' => $document->type, 'document' => $document->id]) }}"
                                               class="btn btn-outline-primary btn-action"
                                               data-bs-toggle="tooltip"
                                               title="Voir le document">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('back.document.edit', ['activity' => $document->activity, 'society' => $document->society, 'type' => $document->type, 'document' => $document->id]) }}"
                                               class="btn btn-outline-secondary btn-action"
                                               data-bs-toggle="tooltip"
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted mb-2">Aucun document trouvé</h5>
                            <p class="text-muted mb-4">Créez votre premier document pour cette société</p>
                            <a href="{{ route('back.document.choose', ['activity' => 'desembouage', 'society' => $societe, 'type' => 'devis']) }}"
                               class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Créer un document
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Clients fréquents -->
    @if($clientsFrequents && count($clientsFrequents) > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h6 class="card-title fw-bold mb-0">
                        <i class="fas fa-users me-2 text-primary"></i>
                        Clients / Adresses Fréquents
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($clientsFrequents as $client)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card border h-100 hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-start justify-content-between mb-2">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1">{{ $client['adresse'] }}</h6>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-file-alt me-1"></i>
                                                {{ $client['total_documents'] }} document(s)
                                            </p>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">
                                            #{{ $loop->iteration }}
                                        </span>
                                    </div>
                                    @if(isset($client['dernier_document']))
                                    <div class="border-top pt-2 mt-2">
                                        <small class="text-muted">
                                            Dernier: {{ $client['dernier_document']->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <a href="{{ route('back.societes.documents', $societe) }}?search={{ urlencode($client['adresse']) }}"
                                       class="btn btn-sm btn-outline-primary w-100">
                                        <i class="fas fa-search me-1"></i>Voir documents
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
/* Styles spécifiques */
.avatar {
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-xl {
    width: 80px;
    height: 80px;
}

.avatar-xs {
    width: 24px;
    height: 24px;
    background: var(--bs-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
}

.btn-action {
    width: 36px;
    height: 36px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px !important;
}

.btn-hover:hover {
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.stat-card {
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.type-badge {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.type-devis {
    background-color: var(--bs-info);
}

.type-facture {
    background-color: var(--bs-success);
}

.type-rapport {
    background-color: var(--bs-warning);
}

.type-cahier_des_charges {
    background-color: var(--bs-purple);
}

.badge.type-devis {
    background-color: var(--bs-info);
    color: white;
}

.badge.type-facture {
    background-color: var(--bs-success);
    color: white;
}

.badge.type-rapport {
    background-color: var(--bs-warning);
    color: white;
}

.badge.type-cahier_des_charges {
    background-color: var(--bs-purple);
    color: white;
}

.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    transition: all 0.3s ease;
}

.empty-state {
    max-width: 400px;
    margin: 0 auto;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.5rem;
}

.table > thead > tr > th {
    font-weight: 600;
    color: var(--bs-gray-700);
    border-bottom: 2px solid var(--bs-gray-200);
}

.table > tbody > tr {
    border-bottom: 1px solid var(--bs-gray-200);
}

.table > tbody > tr:last-child {
    border-bottom: none;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialiser les tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Animation des cartes statistiques
    $('.stat-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
    
    // Gestion des dropdowns
    $('.dropdown-toggle').dropdown();
});
</script>
@endpush