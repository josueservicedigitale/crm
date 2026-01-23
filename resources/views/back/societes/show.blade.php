@extends('back.layouts.principal')

@section('title', 'Société - ' . $nomSociete)

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold text-dark">
                            <i class="fa fa-building me-2 text-primary"></i>
                            {{ $nomSociete }}
                        </h4>
                        <p class="text-muted mb-0">Code: {{ $societe }}</p>
                    </div>
                    <div>
                        <a href="{{ route('back.societe.edit', $societe) }}" class="btn btn-outline-secondary">
                            <i class="fa fa-edit me-2"></i>Éditer
                        </a>
                        <a href="{{ route('back.societe.index') }}" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Informations de la société -->
            <div class="col-md-4">
                <div class="bg-white rounded shadow-sm p-4">
                    <h6 class="fw-bold mb-3">Informations</h6>
                    @if(isset($infosSociete['logo']) && $infosSociete['logo'])
                        <div class="text-center mb-3">
                            <img src="{{ $infosSociete['logo'] }}" alt="Logo {{ $nomSociete }}" class="img-fluid"
                                style="max-height: 100px;">
                        </div>
                    @endif
                    <div class="mb-3">
                        <p><strong>Adresse :</strong></p>
                        <p class="text-muted">{{ $infosSociete['adresse'] ?? 'Non spécifiée' }}</p>
                    </div>
                    @if(isset($infosSociete['telephone']) && $infosSociete['telephone'])
                        <div class="mb-3">
                            <p><strong>Téléphone :</strong> {{ $infosSociete['telephone'] }}</p>
                        </div>
                    @endif
                    @if(isset($infosSociete['email']) && $infosSociete['email'])
                        <div class="mb-3">
                            <p><strong>Email :</strong> {{ $infosSociete['email'] }}</p>
                        </div>
                    @endif
                    @if(isset($infosSociete['siret']) && $infosSociete['siret'])
                        <div class="mb-3">
                            <p><strong>SIRET :</strong> {{ $infosSociete['siret'] }}</p>
                        </div>
                    @endif
                    @if(isset($infosSociete['tva']) && $infosSociete['tva'])
                        <div class="mb-3">
                            <p><strong>TVA :</strong> {{ $infosSociete['tva'] }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistiques globales -->
            <div class="col-md-4">
                <div class="bg-white rounded shadow-sm p-4">
                    <h6 class="fw-bold mb-3">Statistiques Globales</h6>
                    <div class="mb-3">
                        <p class="text-muted small mb-1">Total Documents</p>
                        <h3 class="fw-bold text-primary">{{ $stats['total'] ?? 0 }}</h3>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted small mb-1">Par Activité</p>
                        @foreach(['desembouage', 'reequilibrage'] as $activite)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>{{ ucfirst($activite) }}</span>
                                <span class="badge bg-primary">{{ $stats[$activite] ?? 0 }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <p class="text-muted small mb-1">Par Type</p>
                        @foreach(['devis', 'facture', 'rapport', 'cahier_des_charges'] as $type)
                            @if(isset($stats[$type]))
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                    <span
                                        class="badge bg-{{ $type === 'devis' ? 'info' : ($type === 'facture' ? 'success' : 'warning') }}">
                                        {{ $stats[$type] }}
                                    </span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="col-md-4">
                <div class="bg-white rounded shadow-sm p-4">
                    <h6 class="fw-bold mb-3">Actions Rapides</h6>
                    <div class="d-grid gap-2">
                        @foreach(['desembouage', 'reequilibrage'] as $activite)
                            <a href="{{ route('back.dashboard', ['activity' => $activite, 'society' => $societe]) }}"
                                class="btn btn-outline-primary">
                                <i class="fa fa-tasks me-2"></i>Espace {{ ucfirst($activite) }}
                            </a>
                        @endforeach
                        <a href="{{ route('back.document.choose', ['activity' => 'desembouage', 'society' => $societe, 'type' => 'devis']) }}"
                            class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Nouveau Document
                        </a>
                        <a href="{{ route('back.societe.documents', $societe) }}" class="btn btn-outline-secondary">
                            <i class="fa fa-list me-2"></i>Voir tous les documents
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents récents -->
        @if($documentsRecents && $documentsRecents->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="bg-white rounded shadow-sm p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Documents Récents</h6>
                            <a href="{{ route('back.societe.documents', $societe) }}" class="btn btn-sm btn-outline-primary">
                                Voir tout <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Numéro</th>
                                        <th>Activité</th>
                                        <th>Client/Adresse</th>
                                        <th>Date</th>
                                        <th>Créé par</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documentsRecents as $document)
                                        <tr>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $document->type === 'devis' ? 'info' : ($document->type === 'facture' ? 'success' : 'warning') }}">
                                                    {{ ucfirst($document->type) }}
                                                </span>
                                            </td>
                                            <td>{{ $document->numero }}</td>
                                            <td>{{ $document->activity }}</td>
                                            <td>
                                                {{ $document->client_nom ?? 'N/A' }}
                                                @if($document->adresse_travaux)
                                                    <br><small class="text-muted">{{ $document->adresse_travaux }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $document->date ? $document->date->format('d/m/Y') : ($document->created_at ? $document->created_at->format('d/m/Y') : 'N/A') }}
                                            </td>
                                            <td>{{ $document->user->name ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('back.document.show', ['activity' => $document->activity, 'society' => $document->society, 'type' => $document->type, 'document' => $document->id]) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Voir">
                                                    <i class="fa fa-eye"></i>
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
        @else
            <div class="row mt-4">
                <div class="col-12">
                    <div class="bg-white rounded shadow-sm p-4 text-center">
                        <i class="fa fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun document pour cette société</h5>
                        <p class="text-muted">Commencez par créer votre premier document</p>
                        <a href="{{ route('back.document.choose', ['activity' => 'desembouage', 'society' => $societe, 'type' => 'devis']) }}"
                            class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Créer un document
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Clients fréquents -->
        @if($clientsFrequents && count($clientsFrequents) > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="bg-white rounded shadow-sm p-4">
                        <h6 class="fw-bold mb-3">Clients/Adresses Fréquents</h6>
                        <div class="row">
                            @foreach($clientsFrequents as $client)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card border-light">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $client['adresse'] }}</h6>
                                            <p class="card-text text-muted">
                                                <i class="fa fa-file-alt me-1"></i>
                                                {{ $client['total_documents'] }} document(s)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection