@extends('back.layouts.principal')

@section('title', 'Activité - ' . $nomActivite)

@section('content')
<div class="container-fluid pt-4 px-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white rounded shadow-sm p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar avatar-lg rounded-circle d-flex align-items-center justify-content-center"
                             style="background-color: {{ $activiteModel->couleur ?? '#3B82F6' }}; width: 60px; height: 60px;">
                            <i class="{{ $activiteModel->icon_complete ?? 'fa-tasks' }} fa-2x text-white"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">{{ $nomActivite }}</h4>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-dark">{{ $activite }}</span>
                                @if($activiteModel->est_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-toggle-on me-1"></i>Active
                                </span>
                                @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-toggle-off me-1"></i>Inactive
                                </span>
                                @endif
                                <span class="badge bg-info">
                                    <i class="fas fa-calendar me-1"></i>{{ $stats['ce_mois'] }} ce mois
                                </span>
                            </div>
                            @if($activiteModel->description)
                            <p class="text-muted mb-0 mt-2">
                                {{ $activiteModel->description }}
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('back.activites.edit', $activite) }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-edit me-1"></i>Éditer
                        </a>
                        <a href="{{ route('back.activites.index') }}" 
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cartes statistiques -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Documents</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['total_documents'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="fas fa-file-invoice fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Devis</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['devis_count'] }}</h3>
                            <small class="text-muted">{{ $stats['pourcentages']['devis'] }}% du total</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="fas fa-file-invoice-dollar fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Factures</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['factures_count'] }}</h3>
                            <small class="text-muted">{{ $stats['pourcentages']['factures'] }}% du total</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-md rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="fas fa-chart-line fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Ce mois</h6>
                            <h3 class="fw-bold mb-0">{{ $stats['ce_mois'] }}</h3>
                            <small class="text-muted">documents créés</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Répartition par société -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-building me-2 text-primary"></i>
                        Répartition par Société
                    </h6>
                </div>
                <div class="card-body">
                    @foreach(['nova' => 'Énergie Nova', 'house' => 'MyHouse'] as $key => $label)
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <p class="text-muted small mb-0">{{ $label }}</p>
                            <span class="fw-bold">{{ $stats['societes'][$key] }} docs</span>
                        </div>
                        <div class="progress" style="height: 24px;">
                            <div class="progress-bar bg-{{ $key == 'nova' ? 'primary' : 'success' }} 
                                        d-flex justify-content-between px-3 align-items-center"
                                 style="width: {{ $stats['pourcentages'][$key] }}%; 
                                        min-width: 30px;
                                        transition: width 0.6s ease;">
                                @if($stats['pourcentages'][$key] > 0)
                                    <span class="small">{{ $stats['pourcentages'][$key] }}%</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="mt-4 pt-2 border-top">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Total documents</span>
                            <span class="fw-bold">{{ $stats['total_documents'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Évolution mensuelle -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        Évolution Mensuelle
                    </h6>
                </div>
                <div class="card-body">
                    @if($evolutionMensuelle->count() > 0)
                        @foreach($evolutionMensuelle->take(6) as $mois)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="small">{{ \Carbon\Carbon::createFromFormat('Y-m', $mois->mois)->format('M Y') }}</span>
                                <span class="small fw-bold">{{ $mois->total }} docs</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" 
                                     style="width: {{ ($mois->total / $evolutionMensuelle->max('total')) * 100 }}%">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Devis: {{ $mois->devis }}</small>
                                <small class="text-muted">Factures: {{ $mois->factures }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-4">Aucune donnée pour les 12 derniers mois</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        Actions Rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('back.dashboard', ['activity' => $activite, 'society' => 'nova']) }}" 
                           class="btn btn-outline-primary d-flex align-items-center justify-content-between">
                            <span><i class="fa fa-building me-2"></i>Espace Énergie Nova</span>
                            <span class="badge bg-primary rounded-pill">{{ $stats['societes']['nova'] }}</span>
                        </a>
                        <a href="{{ route('back.dashboard', ['activity' => $activite, 'society' => 'house']) }}" 
                           class="btn btn-outline-success d-flex align-items-center justify-content-between">
                            <span><i class="fa fa-home me-2"></i>Espace MyHouse</span>
                            <span class="badge bg-success rounded-pill">{{ $stats['societes']['house'] }}</span>
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-primary w-100 dropdown-toggle" 
                                    type="button" 
                                    data-bs-toggle="dropdown">
                                <i class="fa fa-plus me-2"></i>Nouveau Document
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li>
                                    <a class="dropdown-item" 
                                       href="{{ route('back.document.choose', ['activity' => $activite, 'society' => 'nova', 'type' => 'devis']) }}">
                                        <i class="fa fa-file-invoice me-2"></i>Devis - Énergie Nova
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" 
                                       href="{{ route('back.document.choose', ['activity' => $activite, 'society' => 'nova', 'type' => 'facture']) }}">
                                        <i class="fa fa-file-invoice-dollar me-2"></i>Facture - Énergie Nova
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" 
                                       href="{{ route('back.document.choose', ['activity' => $activite, 'society' => 'house', 'type' => 'devis']) }}">
                                        <i class="fa fa-file-invoice me-2"></i>Devis - MyHouse
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" 
                                       href="{{ route('back.document.choose', ['activity' => $activite, 'society' => 'house', 'type' => 'facture']) }}">
                                        <i class="fa fa-file-invoice-dollar me-2"></i>Facture - MyHouse
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents récents -->
    @if($documentsRecents->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Documents Récents
                    </h6>
                    <a href="{{ route('back.activites.documents', $activite) }}" 
                       class="btn btn-sm btn-outline-primary">
                        Voir tout <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Type</th>
                                    <th>Référence</th>
                                    <th>Société</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentsRecents as $doc)
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-{{ $doc->type == 'devis' ? 'info' : 'success' }}">
                                            {{ strtoupper($doc->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $doc->numero ?? 'N/A' }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $doc->society }}
                                        </span>
                                    </td>
                                    <td>{{ $doc->client_nom ?? 'N/A' }}</td>
                                    <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                                    <td>{{ number_format($doc->montant_ttc ?? 0, 2) }} €</td>
                                    <td class="text-end pe-4">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection