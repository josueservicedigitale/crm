@extends('back.layouts.principal')

@section('title', 'Documents - ' . $nomActivite)

@section('content')
<div class="container-fluid pt-4 px-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded shadow-sm p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar avatar-lg rounded-circle d-flex align-items-center justify-content-center"
                             style="background-color: {{ $activite->couleur ?? '#3B82F6' }}; width: 60px; height: 60px;">
                            <i class="{{ $activite->icon_complete ?? 'fa-tasks' }} fa-2x text-white"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">
                                <span class="text-primary">Documents</span> - {{ $nomActivite }}
                            </h4>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="badge bg-dark">
                                    <i class="fas fa-code me-1"></i>{{ $activite->code }}
                                </span>
                                <span class="badge bg-info">
                                    <i class="fas fa-file-alt me-1"></i>{{ $documents->total() }} documents
                                </span>
                                @if($activite->est_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-toggle-on me-1"></i>Active
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('back.activites.show', $activite->code) }}" 
                           class="btn btn-outline-primary"
                           data-bs-toggle="tooltip" 
                           title="Retour à l'activité">
                            <i class="fas fa-arrow-left me-1"></i>Retour
                        </a>
                        <a href="{{ route('back.document.choose', ['activity' => $activite->code, 'society' => 'nova', 'type' => 'devis']) }}" 
                           class="btn btn-primary"
                           data-bs-toggle="tooltip" 
                           title="Créer un nouveau document">
                            <i class="fas fa-plus me-1"></i>Nouveau
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded shadow-sm p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label text-muted small fw-bold">RECHERCHE</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0 ps-0" 
                                   id="searchDocuments"
                                   placeholder="Référence, client, adresse..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label text-muted small fw-bold">SOCIÉTÉ</label>
                        <select class="form-select" id="filterSociety">
                            <option value="">Toutes</option>
                            <option value="nova" {{ request('society') == 'nova' ? 'selected' : '' }}>Énergie Nova</option>
                            <option value="house" {{ request('society') == 'house' ? 'selected' : '' }}>MyHouse</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label text-muted small fw-bold">TYPE</label>
                        <select class="form-select" id="filterType">
                            <option value="">Tous</option>
                            <option value="devis" {{ request('type') == 'devis' ? 'selected' : '' }}>Devis</option>
                            <option value="facture" {{ request('type') == 'facture' ? 'selected' : '' }}>Facture</option>
                            <option value="rapport" {{ request('type') == 'rapport' ? 'selected' : '' }}>Rapport</option>
                            <option value="cahier_des_charges" {{ request('type') == 'cahier_des_charges' ? 'selected' : '' }}>Cahier des charges</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label text-muted small fw-bold">PÉRIODE</label>
                        <select class="form-select" id="filterPeriod">
                            <option value="">Toutes</option>
                            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Cette semaine</option>
                            <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Ce mois</option>
                            <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Cette année</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="d-grid">
                            <button class="btn btn-primary" id="applyFilters">
                                <i class="fas fa-filter me-1"></i>Filtrer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md rounded-circle bg-primary bg-opacity-25">
                                <i class="fas fa-file-alt fa-lg text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total documents</h6>
                            <h4 class="fw-bold mb-0">{{ $documents->total() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-info bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md rounded-circle bg-info bg-opacity-25">
                                <i class="fas fa-file-invoice fa-lg text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Devis</h6>
                            <h4 class="fw-bold mb-0">{{ App\Models\Document::where('activity', $activite->code)->where('type', 'devis')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md rounded-circle bg-success bg-opacity-25">
                                <i class="fas fa-file-invoice-dollar fa-lg text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Factures</h6>
                            <h4 class="fw-bold mb-0">{{ App\Models\Document::where('activity', $activite->code)->where('type', 'facture')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md rounded-circle bg-warning bg-opacity-25">
                                <i class="fas fa-clock fa-lg text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Ce mois</h6>
                            <h4 class="fw-bold mb-0">{{ App\Models\Document::where('activity', $activite->code)->whereMonth('created_at', now()->month)->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des documents -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-list me-2 text-primary"></i>
                                Liste des documents
                            </h6>
                            <p class="text-muted small mb-0">
                                {{ $documents->firstItem() ?? 0 }} - {{ $documents->lastItem() ?? 0 }} sur {{ $documents->total() }} documents
                            </p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" 
                                    type="button" 
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-download me-1"></i>Exporter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2 text-success"></i>Excel</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2 text-danger"></i>PDF</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv me-2 text-primary"></i>CSV</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($documents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4" width="50">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th>Référence</th>
                                    <th>Type</th>
                                    <th>Société</th>
                                    <th>Client / Adresse</th>
                                    <th>Date</th>
                                    <th>Montant TTC</th>
                                    <th>Statut</th>
                                    <th>Créé par</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                <tr>
                                    <td class="ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input document-checkbox" 
                                                   type="checkbox" 
                                                   value="{{ $document->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="fas fa-file-{{ $document->type === 'devis' ? 'clipboard' : ($document->type === 'facture' ? 'invoice-dollar' : 'file-alt') }} 
                                                          text-{{ $document->type === 'devis' ? 'info' : ($document->type === 'facture' ? 'success' : 'warning') }} fa-lg">
                                                </i>
                                            </div>
                                            <div>
                                                <strong>{{ $document->numero ?? 'N/A' }}</strong>
                                                @if($document->reference_devis)
                                                <br>
                                                <small class="text-muted">Devis: {{ $document->reference_devis }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $document->type === 'devis' ? 'info' : ($document->type === 'facture' ? 'success' : 'warning') }} bg-opacity-10 text-{{ $document->type === 'devis' ? 'info' : ($document->type === 'facture' ? 'success' : 'warning') }} px-3 py-2">
                                            {{ strtoupper($document->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $document->society === 'nova' ? 'primary' : 'success' }} bg-opacity-10 text-{{ $document->society === 'nova' ? 'primary' : 'success' }}">
                                            <i class="fas fa-{{ $document->society === 'nova' ? 'building' : 'home' }} me-1"></i>
                                            {{ $document->society === 'nova' ? 'Nova' : 'MyHouse' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $document->client_nom ?? 'N/A' }}</strong>
                                            @if($document->adresse_travaux)
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ Str::limit($document->adresse_travaux, 30) }}
                                            </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold">{{ $document->date ? $document->date->format('d/m/Y') : $document->created_at->format('d/m/Y') }}</span>
                                            <br>
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i>{{ $document->created_at->format('H:i') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-{{ $document->montant_ttc > 0 ? 'dark' : 'muted' }}">
                                            {{ number_format($document->montant_ttc ?? 0, 2) }} €
                                        </span>
                                        @if($document->devis_id)
                                        <br>
                                        <small class="text-muted">Devis #{{ $document->devis_id }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statut = $document->statut ?? 'brouillon';
                                            $badgeClass = match($statut) {
                                                'finalisé' => 'success',
                                                'envoyé' => 'primary',
                                                'payé' => 'success',
                                                'annulé' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }} bg-opacity-10 text-{{ $badgeClass }} px-3 py-2">
                                            {{ ucfirst($statut) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2">
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            </div>
                                            <span class="small">{{ $document->user->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('back.document.show', ['activity' => $document->activity, 'society' => $document->society, 'type' => $document->type, 'document' => $document->id]) }}" 
                                               class="btn btn-sm btn-outline-primary"
                                               data-bs-toggle="tooltip"
                                               title="Voir le document">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('back.document.edit', ['activity' => $document->activity, 'society' => $document->society, 'type' => $document->type, 'document' => $document->id]) }}" 
                                               class="btn btn-sm btn-outline-secondary"
                                               data-bs-toggle="tooltip"
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip"
                                                    title="Supprimer"
                                                    onclick="confirmDelete('{{ $document->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <div class="btn-group">
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-info dropdown-toggle dropdown-toggle-split" 
                                                        data-bs-toggle="dropdown"
                                                        data-bs-tooltip="tooltip"
                                                        title="Plus d'actions">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-download me-2 text-primary"></i>Télécharger
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-print me-2 text-secondary"></i>Imprimer
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-envelope me-2 text-info"></i>Envoyer par email
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-copy me-2 text-success"></i>Dupliquer
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#">
                                                            <i class="fas fa-archive me-2"></i>Archiver
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-4 border-top">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="text-muted small">
                                Affichage de {{ $documents->firstItem() ?? 0 }} à {{ $documents->lastItem() ?? 0 }} sur {{ $documents->total() }} documents
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center">
                                    <label class="text-muted small me-2">Lignes par page</label>
                                    <select class="form-select form-select-sm" style="width: 80px;" id="perPage">
                                        <option value="10" {{ $documents->perPage() == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ $documents->perPage() == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ $documents->perPage() == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ $documents->perPage() == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                                {{ $documents->withQueryString()->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <div class="mb-3">
                                <i class="fas fa-file-alt fa-4x text-muted opacity-50"></i>
                            </div>
                            <h5 class="text-muted mb-2">Aucun document trouvé</h5>
                            <p class="text-muted mb-4">
                                Aucun document ne correspond à vos critères de recherche.
                            </p>
                            <a href="{{ route('back.document.choose', ['activity' => $activite->code, 'society' => 'nova', 'type' => 'devis']) }}" 
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
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-0">Êtes-vous sûr de vouloir supprimer ce document ?</p>
                <small class="text-danger">Cette action est irréversible.</small>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .avatar-lg {
        width: 60px;
        height: 60px;
    }
    
    .avatar-md {
        width: 48px;
        height: 48px;
    }
    
    .avatar-xs {
        width: 30px;
        height: 30px;
    }
    
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }
    
    .table > thead > tr > th {
        font-weight: 600;
        color: #4b5563;
        border-bottom-width: 1px;
        background-color: #f9fafb;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    
    .btn-group .btn {
        border-radius: 6px !important;
        margin: 0 2px;
    }
    
    .empty-state {
        max-width: 400px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .page-link {
        border-radius: 6px !important;
        margin: 0 2px;
    }
    
    .form-check-input:checked {
        background-color: #3B82F6;
        border-color: #3B82F6;
    }
    
    /* Animation hover sur les lignes */
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.02);
    }
    
    /* Style pour les tooltips personnalisés */
    .tooltip {
        --bs-tooltip-bg: #1f2937;
        --bs-tooltip-color: white;
        font-size: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialiser tous les tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Sélection/Déselection de tous les documents
    $('#selectAll').change(function() {
        $('.document-checkbox').prop('checked', $(this).prop('checked'));
    });
    
    // Mise à jour de "select all" quand on coche/décoche individuellement
    $(document).on('change', '.document-checkbox', function() {
        if ($('.document-checkbox:checked').length === $('.document-checkbox').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });
    
    // Filtres dynamiques
    $('#applyFilters').click(function() {
        var url = new URL(window.location.href);
        
        // Recherche
        var search = $('#searchDocuments').val();
        if (search) url.searchParams.set('search', search);
        else url.searchParams.delete('search');
        
        // Société
        var society = $('#filterSociety').val();
        if (society) url.searchParams.set('society', society);
        else url.searchParams.delete('society');
        
        // Type
        var type = $('#filterType').val();
        if (type) url.searchParams.set('type', type);
        else url.searchParams.delete('type');
        
        // Période
        var period = $('#filterPeriod').val();
        if (period) url.searchParams.set('period', period);
        else url.searchParams.delete('period');
        
        window.location.href = url.toString();
    });
    
    // Recherche avec touche Entrée
    $('#searchDocuments').keypress(function(e) {
        if (e.which == 13) {
            $('#applyFilters').click();
        }
    });
    
    // Changement du nombre de lignes par page
    $('#perPage').change(function() {
        var url = new URL(window.location.href);
        url.searchParams.set('per_page', $(this).val());
        window.location.href = url.toString();
    });
    
    // Animation d'entrée des cartes
    $('.card').each(function(index) {
        $(this).css({
            'animation': 'fadeInUp 0.3s ease forwards',
            'animation-delay': (index * 0.05) + 's'
        });
    });
});

// Fonction de confirmation de suppression
function confirmDelete(documentId) {
    var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    var form = document.getElementById('deleteForm');
    form.action = `/back/document/${documentId}`; // Adapter selon votre route
    modal.show();
}

// Animation CSS
$('head').append(`
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card {
            opacity: 0;
            animation: fadeInUp 0.3s ease forwards;
        }
    </style>
`);
</script>
@endpush