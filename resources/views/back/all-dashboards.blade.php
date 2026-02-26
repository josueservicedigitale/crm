@extends('back.layouts.principal')

@section('title', 'Tableau de Bord Général')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <!-- En-tête -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold text-dark">
                            <i class="fa fa-tachometer-alt me-2 text-primary"></i>
                            Tableau de Bord Général
                        </h4>
                        <p class="text-muted mb-0">Vue d'ensemble de toutes les activités et sociétés</p>
                    </div>
                    <div>
                        <a href="{{ route('back.all-dashboards') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-arrow-left me-2"></i>Retour Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques Globales -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0">Total Documents</h6>
                                <h2 class="mt-2 fw-bold">{{ $statsGlobales['total_documents'] }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-file-alt fa-3x opacity-50"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small>
                                <i class="fa fa-calendar me-1"></i>
                                Ce mois : {{ $statsGlobales['documents_ce_mois'] }} |
                                Cette semaine : {{ $statsGlobales['documents_semaine'] }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0">Activités</h6>
                                <h2 class="mt-2 fw-bold">{{ $statsGlobales['total_activites'] }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-tasks fa-3x opacity-50"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            @foreach($activitesAvecStats as $key => $activite)
                                <span class="badge bg-light text-dark me-1">
                                    <i class="fa {{ $activite['icon'] }} me-1"></i>{{ $activite['nom'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0">Sociétés</h6>
                                <h2 class="mt-2 fw-bold">{{ $statsGlobales['total_societes'] }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-building fa-3x opacity-50"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            @foreach($societesAvecStats as $key => $societe)
                                <span class="badge bg-light text-dark me-1">
                                    <i class="fa {{ $societe['icon'] }} me-1"></i>{{ $societe['nom'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-dark shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-0">Espaces de Travail</h6>
                                <h2 class="mt-2 fw-bold">{{ $statsGlobales['total_combinaisons'] }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="fa fa-project-diagram fa-3x opacity-50"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small>Combinaisons activité × société</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 1 : Activités -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fa fa-tasks me-2 text-primary"></i>
                            Activités
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            @foreach($activitesAvecStats as $key => $activite) <!-- Notez : activitesAvecStats -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 border rounded">
                                        <div class="me-3">
                                            <i class="fa {{ $activite['icon'] }} fa-2x text-{{ $activite['color'] }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-1">{{ $activite['nom'] }}</h6>
                                            <p class="text-muted small mb-2">{{ $activite['description'] }}</p>
                                            <div class="d-flex">
                                                <a href="{{ route('back.activites.show', parameters: $key) }}"
                                                    class="btn btn-sm btn-outline-{{ $activite['color'] }}">
                                                    <i class="fa fa-eye me-1"></i>Détails
                                                </a>
                                                <span class="ms-auto badge bg-{{ $activite['color'] }}">
                                                    {{ $activite['documents_count'] }} documents <!-- ICI ! -->
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2 : Sociétés -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fa fa-building me-2 text-success"></i>
                            Sociétés
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            @foreach($societesAvecStats as $key => $societe) <!-- Notez : societesAvecStats -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 border rounded">
                                        <div class="me-3">
                                            <i class="fa {{ $societe['icon'] }} fa-2x text-{{ $societe['color'] }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-1">{{ $societe['nom'] }}</h6>
                                            <p class="text-muted small mb-2">{{ $societe['description'] }}</p>
                                            <div class="d-flex">
                                                <a href="{{ route('back.societes.show', $key) }}"
                                                    class="btn btn-sm btn-outline-{{ $societe['color'] }}">
                                                    <i class="fa fa-building me-1"></i>Profil
                                                </a>
                                                <span class="ms-auto badge bg-{{ $societe['color'] }}">
                                                    {{ $societe['documents_count'] }} documents <!-- ICI ! -->
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3 : Tableau des Combinaisons -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fa fa-project-diagram me-2 text-warning"></i>
                            Espaces de Travail (Activité × Société)
                        </h5>
                        <p class="text-muted mb-0 small">Cliquez sur un espace pour accéder au dashboard spécifique</p>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Activité</th>
                                        <th>Société</th>
                                        <th>Documents</th>
                                        <th>Devis</th>
                                        <th>Factures</th>
                                        <th>Rapports</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($combinaisons as $combinaison)
                                                                    <tr class="align-middle">
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <i
                                                                                    class="fa {{ $combinaison['activite_icon'] }} text-{{ $combinaison['activite_color'] }} me-2"></i>
                                                                                <span class="fw-bold">{{ $combinaison['activite_nom'] }}</span>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <i
                                                                                    class="fa {{ $combinaison['societe_icon'] }} text-{{ $combinaison['societe_color'] }} me-2"></i>
                                                                                <span class="fw-bold">{{ $combinaison['societe_nom'] }}</span>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge bg-secondary">{{ $combinaison['documents_count'] }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge bg-info">{{ $combinaison['devis_count'] }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge bg-success">{{ $combinaison['factures_count'] }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge bg-warning">{{ $combinaison['rapports_count'] }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <div class="btn-group btn-group-sm" role="group">
                                                                                <!-- Dashboard principal -->
                                                                                <a href="{{ route('back.dashboard', [
                                            'activity' => $combinaison['activite_code'],
                                            'society' => $combinaison['societe_code']
                                        ]) }}" class="btn btn-primary" title="Dashboard">
                                                                                    <i class="fa fa-tachometer-alt"></i>
                                                                                </a>

                                                                                <!-- Documents -->
                                                                                <a href="{{ route('back.document.list', [
                                            'activity' => $combinaison['activite_code'],
                                            'society' => $combinaison['societe_code'],
                                            'type' => 'devis'
                                        ]) }}" class="btn btn-info" title="Documents">
                                                                                    <i class="fa fa-file-alt"></i>
                                                                                </a>

                                                                                <!-- Création rapide -->
                                                                                <div class="dropdown">
                                                                                    <button class="btn btn-success dropdown-toggle" type="button"
                                                                                        data-bs-toggle="dropdown" title="Créer">
                                                                                        <i class="fa fa-plus"></i>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu">
                                                                                        <li>
                                                                                            <a class="dropdown-item" href="{{ route('back.document.create', [
                                            'activity' => $combinaison['activite_code'],
                                            'society' => $combinaison['societe_code'],
                                            'type' => 'devis'
                                        ]) }}">
                                                                                                <i class="fa fa-file-invoice me-2"></i>Nouveau Devis
                                                                                            </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a class="dropdown-item" href="{{ route('back.document.choose', [
                                            'activity' => $combinaison['activite_code'],
                                            'society' => $combinaison['societe_code'],
                                            'type' => 'facture'
                                        ]) }}">
                                                                                                <i class="fa fa-file-invoice-dollar me-2"></i>Nouvelle
                                                                                                Facture
                                                                                            </a>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a class="dropdown-item" href="{{ route('back.document.choose', [
                                            'activity' => $combinaison['activite_code'],
                                            'society' => $combinaison['societe_code'],
                                            'type' => 'attestation_realisation'
                                        ]) }}">
                                                                                                <i class="fa fa-check-circle me-2"></i>Nouvelle Attestation
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>

                                                                                <!-- Rapports -->
                                                                                <a href="{{ route('back.document.list', [
                                            'activity' => $combinaison['activite_code'],
                                            'society' => $combinaison['societe_code'],
                                            'type' => 'rapport'
                                        ]) }}" class="btn btn-warning" title="Rapports">
                                                                                    <i class="fa fa-chart-line"></i>
                                                                                </a>

                                                                                <!-- Cahiers des charges -->
                                                                                <a href="{{ route('back.document.list', [
                                            'activity' => $combinaison['activite_code'],
                                            'society' => $combinaison['societe_code'],
                                            'type' => 'cahier_des_charges'
                                        ]) }}" class="btn btn-dark" title="Cahiers des charges">
                                                                                    <i class="fa fa-book"></i>
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Carte de résumé -->
                        <div class="card-footer bg-light">
                            <div class="row">
                                <div class="col-md-4">
                                    <small class="text-muted">
                                        <i class="fa fa-info-circle me-1"></i>
                                        Total : {{ count($combinaisons) }} espaces de travail
                                    </small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <small class="text-muted">
                                        <i class="fa fa-lightbulb me-1"></i>
                                        Cliquez sur les icônes pour accéder aux différentes sections
                                    </small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{ route('back.all-dashboards') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-external-link-alt me-1"></i>Vue détaillée
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
            cursor: pointer;
        }

        .btn-group .btn {
            border-radius: 4px !important;
            margin: 0 2px;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ajouter un effet de clic sur les lignes du tableau
            document.querySelectorAll('tbody tr').forEach(row => {
                row.addEventListener('click', function (e) {
                    // Ne pas déclencher si on clique sur un bouton
                    if (!e.target.closest('button') && !e.target.closest('a')) {
                        const firstLink = this.querySelector('a[href]');
                        if (firstLink) {
                            window.location = firstLink.href;
                        }
                    }
                });
            });

            // Afficher un message de chargement
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function () {
                    if (this.getAttribute('href')) {
                        this.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i>Chargement...';
                    }
                });
            });
        });
    </script>
@endsection