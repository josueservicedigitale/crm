@extends('back.layouts.principal')

@section('title', 'Dashboard CRM - ' . ($appName ?? '360INVEST'))

@section('content')
<div class="container-fluid pt-4 px-4">
    <!-- ================================================================= -->
    <!-- 1. KPI PRINCIPAUX - 4 CARTES AÉRÉES -->
    <!-- ================================================================= -->
    <div class="row g-4 mb-4">
        <!-- Carte 1: Documents Totaux -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-lg rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fas fa-file-contract fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small fw-bold mb-1">Documents Totaux</h6>
                        <h2 class="fw-bold mb-0">{{ number_format($kpi['total_documents'], 0, ',', ' ') }}</h2>
                        <div class="d-flex align-items-center mt-2">
                            <span class="badge bg-light text-dark p-2">
                                <i class="fas fa-calendar me-1"></i>{{ $kpi['documents_ce_mois'] }} ce mois
                            </span>
                            <span class="badge bg-light text-dark p-2 ms-2" data-bs-toggle="tooltip" title="Aujourd'hui">
                                <i class="fas fa-clock me-1"></i>{{ $kpi['documents_aujourdhui'] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 2: Sociétés Actives -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-lg rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fas fa-building fa-2x text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Sociétés Actives</h6>
                        <h2 class="fw-bold mb-0">{{ $kpi['societes_actives'] }}</h2>
                        <div class="d-flex align-items-center mt-2">
                            <span class="badge bg-light text-dark p-2">
                                <i class="fas fa-building me-1"></i>{{ $kpi['societes_total'] }} total
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 3: Activités -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-lg rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fas fa-tasks fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-white text-uppercase small fw-bold mb-1">Activités</h6>
                        <h2 class="fw-bold mb-0">{{ $kpi['activites_actives'] }}</h2>
                        <div class="d-flex align-items-center mt-2">
                            @foreach($statsActivites as $activite)
                            <span class="badge me-1" style="background-color: {{ $activite['couleur'] }}20; color: {{ $activite['couleur'] }}; border: 1px solid {{ $activite['couleur'] }}40;">
                                <i class="fas {{ $activite['icon'] }} me-1"></i>{{ $activite['documents_count'] }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 4: Utilisateurs en ligne -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-lg rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Utilisateurs</h6>
                        <div class="d-flex align-items-baseline">
                            <h2 class="fw-bold mb-0">{{ $kpi['utilisateurs_en_ligne'] }}</h2>
                            <span class="text-muted ms-1 small">/ {{ $kpi['utilisateurs_total'] }}</span>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <span class="badge bg-success bg-opacity-10 text-success p-2">
                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i>{{ $kpi['utilisateurs_en_ligne'] }} en ligne
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- 2. KPI SECONDAIRES - 4 CARTES SUPPLÉMENTAIRES -->
    <!-- ================================================================= -->
    <div class="row g-4 mb-4">
        <!-- Carte 5: Documents ce mois -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-primary bg-opacity-5">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white small text-uppercase fw-bold">Documents</span>
                        <h3 class="fw-bold mb-0">{{ $kpi['documents_ce_mois'] }}</h3>
                        <span class="text-white small">ce mois</span>
                    </div>
                    <div class="avatar avatar-md rounded-circle bg-primary bg-opacity-10">
                        <i class="fas fa-calendar-alt text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 6: Documents semaine -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-success bg-opacity-5">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white small text-uppercase fw-bold">Documents</span>
                        <h3 class="fw-bold mb-0">{{ $kpi['documents_cette_semaine'] }}</h3>
                        <span class="text-white small">cette semaine</span>
                    </div>
                    <div class="avatar avatar-md rounded-circle bg-success bg-opacity-10">
                        <i class="fas fa-clock text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 7: Taux de conversion -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-warning bg-opacity-5">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">Conversion</span>
                        <h3 class="fw-bold mb-0">{{ $statsRapides['taux_conversion']['taux'] }}%</h3>
                        <span class="text-muted small">{{ $statsRapides['taux_conversion']['converti'] }}/{{ $statsRapides['taux_conversion']['total'] }} devis</span>
                    </div>
                    <div class="avatar avatar-md rounded-circle bg-warning bg-opacity-10">
                        <i class="fas fa-chart-line text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 8: Corbeille -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-danger bg-opacity-5">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white small text-uppercase fw-bold">Corbeille</span>
                        <h3 class="fw-bold mb-0">{{ $kpi['corbeille_total'] }}</h3>
                        <span class="text-danger small">{{ $kpi['corbeille_expiration_7j'] }} expirent bientôt</span>
                    </div>
                    <div class="avatar avatar-md rounded-circle bg-danger bg-opacity-10">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- 3. GRAPHIQUES -->
    <!-- ================================================================= -->
    <div class="row g-4 mb-4">
        <!-- Graphique: Évolution mensuelle -->
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-chart-bar me-2 text-primary"></i>
                                Évolution des documents
                            </h6>
                            <p class="text-muted small mb-0">12 derniers mois</p>
                        </div>
                        <a href="{{ route('back.documents.tous') }}" class="btn btn-sm btn-outline-primary">
                            Voir tout <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="documentsChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Graphique: Répartition par type -->
        <div class="col-xl-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-chart-pie me-2 text-primary"></i>
                                Répartition par type
                            </h6>
                            <p class="text-white small mb-0">Total: {{ number_format($kpi['total_documents'], 0, ',', ' ') }} documents</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="typesChart" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- 4. DOCUMENTS RÉCENTS -->
    <!-- ================================================================= -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="fw-bold mb-0">
                                <i class="fas fa-history me-2 text-primary"></i>
                                Documents récents
                            </h6>
                            <p class="text-white small mb-0">{{ $documentsRecents->count() }} derniers documents</p>
                        </div>
                        <a href="{{ route('back.documents.tous') }}" class="btn btn-sm btn-outline-primary">
                            Voir tous <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Référence</th>
                                    <th>Type</th>
                                    <th>Société</th>
                                    <th>Activité</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Créé par</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documentsRecents as $doc)
                                <tr>
                                    <td class="ps-4">
                                        <strong>{{ $doc['reference'] }}</strong>
                                    </td>
                                    <td>
    <span class="badge bg-{{ $doc['type']['couleur'] }} text-white px-3 py-2">
        {{ $doc['type']['nom'] }}
    </span>
</td>

                                    <td>
                                        <span class="badge bg-{{ $doc['societe']['couleur'] }} bg-opacity-10 text-{{ $doc['societe']['couleur'] }}">
                                            <i class="fas {{ $doc['societe']['code'] === 'nova' ? 'fa-building' : 'fa-home' }} me-1"></i>
                                            {{ $doc['societe']['nom'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $doc['activite']['couleur'] }} bg-opacity-10 text-{{ $doc['activite']['couleur'] }}">
                                            <i class="fas {{ $doc['activite']['code'] === 'desembouage' ? 'fa-water' : 'fa-balance-scale' }} me-1"></i>
                                            {{ $doc['activite']['nom'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <span>{{ $doc['date'] }}</span>
                                            <br>
                                            <small class="text-muted">{{ $doc['heure'] }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $doc['statut']['couleur'] }} bg-opacity-10 text-{{ $doc['statut']['couleur'] }} px-3 py-2">
                                            {{ ucfirst($doc['statut']['nom']) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-xs me-2">
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            </div>
                                            <span class="small">{{ $doc['user'] }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ $doc['url_preview'] }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               target="_blank"
                                               data-bs-toggle="tooltip" 
                                               title="Prévisualiser le PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            <a href="{{ $doc['url_edit'] }}" 
                                               class="btn btn-sm btn-outline-warning"
                                               data-bs-toggle="tooltip" 
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ $doc['url_download'] }}" 
                                               class="btn btn-sm btn-outline-success"
                                               data-bs-toggle="tooltip" 
                                               title="Télécharger">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                            <h6 class="text-muted">Aucun document récent</h6>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- 5. TROIS COLONNES : ACTIVITÉS RÉCENTES | STATS SOCIÉTÉS | ACTIONS RAPIDES -->
    <!-- ================================================================= -->
    <div class="row g-4 mb-4">
        <!-- Colonne 1: Activités récentes -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-bell me-2 text-primary"></i>
                            Activités récentes
                        </h6>
                        <a href="#" class="btn btn-sm btn-outline-secondary">Voir tout</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($activitesRecentes as $activite)
                        <div class="list-group-item border-0 py-3 px-4">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-md rounded-circle d-flex align-items-center justify-content-center"
                                         style="background-color: {{ $activite['couleur'] }}15; width: 48px; height: 48px;">
                                        <i class="fas {{ $activite['icone'] }} fa-lg" style="color: {{ $activite['couleur'] === 'primary' ? '#0d6efd' : ($activite['couleur'] === 'success' ? '#198754' : ($activite['couleur'] === 'warning' ? '#ffc107' : '#0dcaf0')) }};"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="mb-0 fw-bold">{{ $activite['action'] }}</h6>
                                        <small class="text-muted" data-bs-toggle="tooltip" title="{{ $activite['created_at']->format('d/m/Y H:i') }}">
                                            {{ $activite['diffusion'] }}
                                        </small>
                                    </div>
                                    <p class="mb-1 text-muted small">{{ $activite['description'] }}</p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-light text-dark me-2">
                                            <i class="fas fa-user me-1"></i>{{ $activite['user'] }}
                                        </span>
                                        @if(isset($activite['is_online']) && $activite['is_online'])
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>En ligne
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucune activité récente</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne 2: Statistiques par société -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-building me-2 text-primary"></i>
                            Documents par société
                        </h6>
                        <a href="{{ route('back.societes.index') }}" class="btn btn-sm btn-outline-secondary">Gérer</a>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($statsSocietes as $societe)
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm rounded-circle me-2 d-flex align-items-center justify-content-center"
                                     style="background-color: {{ $societe['couleur'] }}20; width: 32px; height: 32px;">
                                    <i class="fas {{ $societe['icon'] }}" style="color: {{ $societe['couleur'] }};"></i>
                                </div>
                                <span class="fw-bold">{{ $societe['nom'] }}</span>
                            </div>
                            <span class="fw-bold">{{ number_format($societe['documents_count'], 0, ',', ' ') }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar" 
                                 style="width: {{ $societe['percentage'] }}%; background-color: {{ $societe['couleur'] }};"
                                 role="progressbar"
                                 data-bs-toggle="tooltip"
                                 title="{{ $societe['percentage'] }}% ({{ number_format($societe['documents_count'], 0, ',', ' ') }} documents)">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-1">
                            <small class="text-muted">{{ $societe['percentage'] }}%</small>
                        </div>
                    </div>
                    @endforeach

                    <hr class="my-4">

                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-tasks me-2 text-primary"></i>
                        Documents par activité
                    </h6>
                    @foreach($statsActivites as $activite)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm rounded-circle me-2 d-flex align-items-center justify-content-center"
                                 style="background-color: {{ $activite['couleur'] }}20; width: 32px; height: 32px;">
                                <i class="fas {{ $activite['icon'] }}" style="color: {{ $activite['couleur'] }};"></i>
                            </div>
                            <span>{{ $activite['nom'] }}</span>
                        </div>
                        <div>
                            <span class="fw-bold me-2">{{ number_format($activite['documents_count'], 0, ',', ' ') }}</span>
                            <span class="badge" style="background-color: {{ $activite['couleur'] }}20; color: {{ $activite['couleur'] }};">
                                {{ $activite['percentage'] }}%
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Colonne 3: Actions rapides -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        Actions rapides
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Actions principales -->
                    <div class="d-grid gap-2 mb-4">
                        <a href="{{ route('back.documents.creation-rapide') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Nouveau document
                        </a>
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <a href="{{ route('back.document.choose', ['activity' => 'desembouage', 'society' => 'nova', 'type' => 'devis']) }}" 
                               class="btn btn-outline-primary w-100 d-flex flex-column align-items-center py-3"
                               data-bs-toggle="tooltip"
                               title="Nouveau devis Énergie Nova">
                                <i class="fas fa-file-invoice fa-xl mb-2"></i>
                                <span class="small">Devis Nova</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('back.document.choose', ['activity' => 'desembouage', 'society' => 'house', 'type' => 'devis']) }}" 
                               class="btn btn-outline-success w-100 d-flex flex-column align-items-center py-3"
                               data-bs-toggle="tooltip"
                               title="Nouveau devis MyHouse">
                                <i class="fas fa-file-invoice fa-xl mb-2"></i>
                                <span class="small">Devis House</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('back.document.choose', ['activity' => 'reequilibrage', 'society' => 'nova', 'type' => 'facture']) }}" 
                               class="btn btn-outline-info w-100 d-flex flex-column align-items-center py-3"
                               data-bs-toggle="tooltip"
                               title="Nouvelle facture Énergie Nova">
                                <i class="fas fa-file-invoice-dollar fa-xl mb-2"></i>
                                <span class="small">Facture Nova</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('back.document.choose', ['activity' => 'reequilibrage', 'society' => 'house', 'type' => 'facture']) }}" 
                               class="btn btn-outline-warning w-100 d-flex flex-column align-items-center py-3"
                               data-bs-toggle="tooltip"
                               title="Nouvelle facture MyHouse">
                                <i class="fas fa-file-invoice-dollar fa-xl mb-2"></i>
                                <span class="small">Facture House</span>
                            </a>
                        </div>
                    </div>

                    <!-- Statistiques rapides -->
                    <div class="bg-light rounded p-3">
                        <h6 class="fw-bold mb-3">Statistiques du mois</h6>
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="bg-primary bg-opacity-10 rounded p-2">
                                    <h4 class="text-primary mb-0 fw-bold">{{ $statsRapides['devis_ce_mois'] }}</h4>
                                    <small class="text-muted">Devis</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="bg-success bg-opacity-10 rounded p-2">
                                    <h4 class="text-success mb-0 fw-bold">{{ $statsRapides['factures_ce_mois'] }}</h4>
                                    <small class="text-muted">Factures</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-warning bg-opacity-10 rounded p-2">
                                    <h4 class="text-warning mb-0 fw-bold">{{ $statsRapides['attestations_ce_mois'] }}</h4>
                                    <small class="text-muted">Attestations</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-info bg-opacity-10 rounded p-2">
                                    <h4 class="text-info mb-0 fw-bold">{{ $statsRapides['rapports_ce_mois'] }}</h4>
                                    <small class="text-muted">Rapports</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Corbeille - Expiration bientôt -->
                    @if($corbeilleBientotExpire->count() > 0)
                    <div class="mt-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="fw-bold mb-0 text-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Expiration imminente
                            </h6>
                            <a href="{{ route('back.corbeille.index') }}" class="btn btn-sm btn-outline-danger">Voir</a>
                        </div>
                        @foreach($corbeilleBientotExpire->take(3) as $item)
                        <div class="d-flex align-items-center justify-content-between mb-2 p-2 bg-danger bg-opacity-5 rounded">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-trash-alt text-danger me-2"></i>
                                <div>
                                    <small class="fw-bold">{{ $item['type'] }}</small>
                                    <br>
                                    <small class="text-muted">Supprimé par {{ $item['supprime_par'] }}</small>
                                </div>
                            </div>
                            <span class="badge bg-danger">{{ $item['jours_restants'] }}j</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Initialiser tous les tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // =====================================================================
    // GRAPHIQUE 1: Évolution mensuelle
    // =====================================================================
    const ctx1 = document.getElementById('documentsChart').getContext('2d');
    const evolutionData = @json($evolutionMensuelle);
    
    const months = evolutionData.map(item => item.mois);
    const counts = evolutionData.map(item => item.total);

    const documentsChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Documents',
                data: counts,
                backgroundColor: 'rgba(13, 110, 253, 0.7)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1,
                borderRadius: 6,
                barPercentage: 0.7,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            const index = context[0].dataIndex;
                            return evolutionData[index]?.mois_complet || context[0].label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgb(255, 255, 255)' },
                    title: {
                        display: true,
                        text: 'Nombre de documents'
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // =====================================================================
    // GRAPHIQUE 2: Répartition par type
    // =====================================================================
    const ctx2 = document.getElementById('typesChart').getContext('2d');
    const typesData = @json($repartitionTypes);
    
    const colors = [
        'rgba(13, 110, 253, 0.9)',   // Devis - Bleu
        'rgba(25, 135, 84, 0.9)',    // Factures - Vert
        'rgba(13, 202, 240, 0.9)',   // Rapports - Cyan
        'rgba(255, 193, 7, 0.9)',    // Attestations - Jaune
        'rgb(253, 253, 253)',  // Cahiers - Gris
    ];

    const typesChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: Object.keys(typesData),
            datasets: [{
                data: Object.values(typesData),
                backgroundColor: colors.slice(0, Object.keys(typesData).length),
                borderWidth: 2,
                borderColor: 'white',
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 20, usePointStyle: true, pointStyle: 'circle' }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: ${value} documents (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // Animation des cartes au survol
    $('.card').hover(
        function() { $(this).addClass('shadow'); },
        function() { $(this).removeClass('shadow'); }
    );
});
</script>
@endsection