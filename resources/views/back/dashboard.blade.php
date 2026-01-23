@extends('back.layouts.principal')

@section('title', 'Dashboard CRM')

@section('content')
    <!-- Statistiques CRM Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-file-contract fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Documents Totaux</p>
                        <h6 class="mb-0">78</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-building fa-3x text-success"></i>
                    <div class="ms-3">
                        <p class="mb-2">Sociétés Actives</p>
                        <h6 class="mb-0">2</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-tasks fa-3x text-warning"></i>
                    <div class="ms-3">
                        <p class="mb-2">Types d'Activités</p>
                        <h6 class="mb-0">DESEMBOUAGE </h6>
                        <h6 class="mb-0">REQUILIBRAGE </h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-chart-line fa-3x text-info"></i>
                    <div class="ms-3">
                        <p class="mb-2">Taux de Conversion</p>
                        <h6 class="mb-0">87%</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Statistiques CRM End -->

    <!-- Graphiques CRM Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Documents par Mois</h6>
                        <a href="#">Voir Tout</a>
                    </div>
                    <canvas id="documentsChart"></canvas>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Répartition par Type</h6>
                        <a href="#">Détails</a>
                    </div>
                    <canvas id="typesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Graphiques CRM End -->

    <!-- Documents Récents Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Documents Récents</h6>
                <a href="#">Voir Tout</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">Référence</th>
                            <th scope="col">Type</th>
                            <th scope="col">Société</th>
                            <th scope="col">Activité</th>
                            <th scope="col">Date</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>DEV-NOVA-2024-001</td>
                            <td>
                                <span class="badge bg-primary">
                                    Devis
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    Nova
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-warning">
                                    Désembouage
                                </span>
                            </td>
                            <td>15/03/2024</td>
                            <td>
                                <span class="badge bg-success">
                                    Signé
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="#">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-success" href="#">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>FACT-HOUSE-2024-056</td>
                            <td>
                                <span class="badge bg-success">
                                    Facture
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    House
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    Rééquilibrage
                                </span>
                            </td>
                            <td>14/03/2024</td>
                            <td>
                                <span class="badge bg-info">
                                    Validé
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="#">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-success" href="#">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>ATT-NOVA-2024-123</td>
                            <td>
                                <span class="badge bg-warning">
                                    Attestation réalisation
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    Nova
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-warning">
                                    Désembouage
                                </span>
                            </td>
                            <td>13/03/2024</td>
                            <td>
                                <span class="badge bg-success">
                                    Signé
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="#">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-success" href="#">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>RAPP-HOUSE-2024-034</td>
                            <td>
                                <span class="badge bg-secondary">
                                    Rapport
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    House
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    Rééquilibrage
                                </span>
                            </td>
                            <td>12/03/2024</td>
                            <td>
                                <span class="badge bg-dark">
                                    Archivé
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="#">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-success" href="#">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>DEV-HOUSE-2024-089</td>
                            <td>
                                <span class="badge bg-primary">
                                    Devis
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    House
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-warning">
                                    Désembouage
                                </span>
                            </td>
                            <td>11/03/2024</td>
                            <td>
                                <span class="badge bg-secondary">
                                    En attente
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="#">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-success" href="#">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>ATT-NOVA-2024-125</td>
                            <td>
                                <span class="badge bg-info">
                                    Attestation signataire
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    Nova
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-warning">
                                    Désembouage
                                </span>
                            </td>
                            <td>10/03/2024</td>
                            <td>
                                <span class="badge bg-success">
                                    Signé
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="#">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-success" href="#">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>CDCH-NOVA-2024-045</td>
                            <td>
                                <span class="badge bg-dark">
                                    Cahier des charges
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    Nova
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    Rééquilibrage
                                </span>
                            </td>
                            <td>09/03/2024</td>
                            <td>
                                <span class="badge bg-info">
                                    Validé
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="#">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-success" href="#">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Documents Récents End -->

    <!-- Vue d'ensemble & Activités Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <!-- Activités Récentes -->
            <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="mb-0">Activités Récentes</h6>
                        <a href="#">Voir Tout</a>
                    </div>
                    <div class="d-flex align-items-center border-bottom py-3">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-file-signature text-white"></i>
                        </div>
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-0">Nouveau devis créé</h6>
                                <small>Il y a 2 heures</small>
                            </div>
                            <span>DEV-NOVA-2024-128 • Désembouage</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center border-bottom py-3">
                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-file-invoice-dollar text-white"></i>
                        </div>
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-0">Facture générée</h6>
                                <small>Il y a 5 heures</small>
                            </div>
                            <span>FACT-HOUSE-2024-057 • Rééquilibrage</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center border-bottom py-3">
                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-stamp text-white"></i>
                        </div>
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-0">Attestation signée</h6>
                                <small>Il y a 1 jour</small>
                            </div>
                            <span>ATT-NOVA-2024-124 • Désembouage</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center pt-3">
                        <div class="rounded-circle bg-info d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-chart-pie text-white"></i>
                        </div>
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-0">Rapport téléchargé</h6>
                                <small>Il y a 2 jours</small>
                            </div>
                            <span>RAPP-HOUSE-2024-035 • Rééquilibrage</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques par Société -->
            <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Statistiques par Société</h6>
                        <a href="#">Détails</a>
                    </div>
                    <div class="mb-3">
                        <h6 class="mb-1">Energienova</h6>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-primary" style="width: 65%;" role="progressbar"></div>
                        </div>
                        <small class="text-muted">65% des documents</small>
                    </div>
                    <div class="mb-3">
                        <h6 class="mb-1">Energyhouse</h6>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: 35%;" role="progressbar"></div>
                        </div>
                        <small class="text-muted">35% des documents</small>
                    </div>

                    <div class="mt-4">
                        <h6 class="mb-3">Documents par Activité</h6>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Désembouage</span>
                            <span>842</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: 60%;" role="progressbar"></div>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Rééquilibrage</span>
                            <span>406</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: 40%;" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Rapides -->
            <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Actions Rapides</h6>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Nouveau Devis
                        </a>
                        <a href="#" class="btn btn-success">
                            <i class="fas fa-file-invoice me-2"></i>Créer Facture
                        </a>
                        <a href="#" class="btn btn-warning">
                            <i class="fas fa-stamp me-2"></i>Générer Attestation
                        </a>
                        <a href="#" class="btn btn-info">
                            <i class="fas fa-chart-bar me-2"></i>Créer Rapport
                        </a>
                        <a href="#" class="btn btn-secondary">
                            <i class="fas fa-file-pdf me-2"></i>Gérer Templates PDF
                        </a>
                    </div>

                    <div class="mt-4">
                        <h6 class="mb-3">Statistiques Rapides</h6>
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="p-3 bg-primary bg-opacity-10 rounded">
                                    <h4 class="text-white">42</h4>
                                    <small class="text-white">Devis ce mois</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="p-3 bg-success bg-opacity-10 rounded">
                                    <h4 class="text-white">38</h4>
                                    <small class="text-white">Factures ce mois</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-warning bg-opacity-10 rounded">
                                    <h4 class="text-white">24</h4>
                                    <small class="text-white">Attestations</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-info bg-opacity-10 rounded">
                                    <h4 class="text-white">18</h4>
                                    <small class="text-white">Rapports</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vue d'ensemble & Activités End -->

    <!-- Footer Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded-top p-4">
            <div class="row">
                <div class="col-12 col-sm-6 text-center text-sm-start">
                    &copy; <a href="#">360INVEST</a>, All Right Reserved.
                </div>
                <div class="col-12 col-sm-6 text-center text-sm-end">
                    Designed By <a href="https://360invest.com">360INVEST</a>
                </div>
            </div>
        </div>
    </div>

    </div>


@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Graphique Documents par Mois
        const ctx1 = document.getElementById('documentsChart').getContext('2d');
        const documentsChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Documents',
                    data: [65, 78, 92, 85, 105, 120, 135, 110, 95, 115, 125, 140],
                    backgroundColor: 'rgba(13, 110, 253, 0.7)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre de documents'
                        }
                    }
                }
            }
        });

        // Graphique Répartition par Type
        const ctx2 = document.getElementById('typesChart').getContext('2d');
        const typesChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Devis', 'Factures', 'Attestations', 'Rapports', 'Cahiers'],
                datasets: [{
                    data: [35, 25, 20, 15, 5],
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.8)',
                        'rgba(25, 135, 84, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(13, 202, 240, 0.8)',
                        'rgba(108, 117, 125, 0.8)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>


@endsection