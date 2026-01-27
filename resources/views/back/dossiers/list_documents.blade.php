@extends('back.layouts.principal')

@section('title', 'Liste des ' . ucfirst($type === 'all' ? 'Documents' : $type . 's'))

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold text-dark">
                        <i class="fa fa-list me-2"></i>
                        @if($type === 'all')
                        Tous les documents – {{ ucfirst($society) }} / {{ ucfirst($activity) }}
                        @else
                        {{ ucfirst($type) }}s – {{ ucfirst($society) }} / {{ ucfirst($activity) }}
                        @endif
                    </h4>
                    <p class="text-muted mb-0">
                        @if($type === 'all')
                        Affichage de tous les types de documents
                        @else
                        Type spécifique: {{ $type }}
                        @endif
                    </p>
                </div>
                <div>
                    <a href="{{ route('back.dashboard', [$activity, $society]) }}" 
                       class="btn btn-outline-primary">
                        <i class="fa fa-arrow-left me-1"></i> Retour au tableau de bord
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    @if(isset($stats) && count($stats) > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body py-3">
                    <div class="row">
                        @if($type === 'all')
                        <div class="col-md-2 col-6 mb-2">
                            <div class="text-center">
                                <h5 class="fw-bold text-primary">{{ $stats['total'] ?? 0 }}</h5>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-2">
                            <div class="text-center">
                                <h5 class="fw-bold text-info">{{ $stats['devis'] ?? 0 }}</h5>
                                <small class="text-muted">Devis</small>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-2">
                            <div class="text-center">
                                <h5 class="fw-bold text-success">{{ $stats['factures'] ?? 0 }}</h5>
                                <small class="text-muted">Factures</small>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-2">
                            <div class="text-center">
                                <h5 class="fw-bold text-warning">{{ $stats['rapports'] ?? 0 }}</h5>
                                <small class="text-muted">Rapports</small>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-2">
                            <div class="text-center">
                                <h5 class="fw-bold text-secondary">{{ $stats['cahiers'] ?? 0 }}</h5>
                                <small class="text-muted">Cahiers</small>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-2">
                            <div class="text-center">
                                <h5 class="fw-bold text-dark">{{ $stats['attestations'] ?? 0 }}</h5>
                                <small class="text-muted">Attestations</small>
                            </div>
                        </div>
                        @else
                        <div class="col-md-3 col-6 mb-2">
                            <div class="text-center">
                                <h5 class="fw-bold text-primary">{{ $stats['total'] ?? 0 }}</h5>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <div class="text-center">
                                <h5 class="fw-bold text-info">{{ $stats['ce_mois'] ?? 0 }}</h5>
                                <small class="text-muted">Ce mois</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <div class="text-center">
                                <h5 class="fw-bold text-success">{{ $stats['cette_semaine'] ?? 0 }}</h5>
                                <small class="text-muted">Cette semaine</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-2">
                            <div class="text-center">
                                <h5 class="fw-bold text-dark">{{ $documents->total() }}</h5>
                                <small class="text-muted">Affichés</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Filtres rapides -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">Filtres</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('back.document.list', [$activity, $society, $type]) }}">
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Rechercher par référence, nom, adresse..."
                                           value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    @if(request('search'))
                                    <a href="{{ route('back.document.list', [$activity, $society, $type]) }}" 
                                       class="btn btn-outline-secondary">
                                        <i class="fa fa-times"></i>
                                    </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        @if($type === 'all')
                        <div class="col-md-4">
                            <div class="btn-group w-100">
                                <a href="{{ route('back.document.list', [$activity, $society, 'devis']) }}" 
                                   class="btn btn-outline-info">
                                    Devis
                                </a>
                                <a href="{{ route('back.document.list', [$activity, $society, 'facture']) }}" 
                                   class="btn btn-outline-success">
                                    Factures
                                </a>
                                <a href="{{ route('back.document.list', [$activity, $society, 'rapport']) }}" 
                                   class="btn btn-outline-warning">
                                    Rapports
                                </a>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-4">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('back.documents.creation-rapide') }}" 
                                   class="btn btn-primary">
                                    <i class="fa fa-plus me-1"></i> Nouveau document
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des documents -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($documents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        @if($type === 'all')
                                        <th>Type</th>
                                        @endif
                                        <th>Référence</th>
                                        <th>Date</th>
                                        <th>Client / Résidence</th>
                                        <th>Adresse travaux</th>
                                        <th>Montant TTC</th>
                                        <th>Créé le</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $doc)
                                    <tr>
                                        @if($type === 'all')
                                        <td>
                                            @php
                                                $typeColor = match($doc->type) {
                                                    'devis' => 'info',
                                                    'facture' => 'success',
                                                    'rapport' => 'warning',
                                                    'cahier_des_charges' => 'secondary',
                                                    'attestation_realisation', 'attestation_signataire' => 'dark',
                                                    default => 'primary'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $typeColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $doc->type)) }}
                                            </span>
                                        </td>
                                        @endif
                                        <td>
                                            <strong class="d-block">{{ $doc->reference ?? 'N/A' }}</strong>
                                            @if($doc->reference_devis)
                                            <small class="text-muted">Devis: {{ $doc->reference_devis }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($doc->date_devis)
                                                {{ \Carbon\Carbon::parse($doc->date_devis)->format('d/m/Y') }}
                                            @elseif($doc->created_at)
                                                {{ $doc->created_at->format('d/m/Y') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($doc->nom_residence)
                                                <strong>{{ $doc->nom_residence }}</strong>
                                            @else
                                                <span class="text-muted">Non spécifié</span>
                                            @endif
                                            @if($doc->nombre_logements)
                                            <br>
                                            <small class="text-muted">
                                                <i class="fa fa-home me-1"></i>{{ $doc->nombre_logements }} logement(s)
                                            </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($doc->adresse_travaux)
                                               {{ str($doc->adresse_travaux)->limit(40) }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($doc->montant_ttc)
                                                <span class="fw-bold">{{ number_format($doc->montant_ttc, 2, ',', ' ') }} €</span>
                                                @if($doc->prime_cee)
                                                <br>
                                                <small class="text-success">
                                                    Prime CEE: {{ number_format($doc->prime_cee, 2, ',', ' ') }} €
                                                </small>
                                                @endif
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $doc->created_at->format('d/m/Y H:i') }}
                                            <br>
                                            <small class="text-muted">
                                                par {{ $doc->user->name ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <!-- Voir le document -->
                                                <a href="{{ route('back.document.show', [$doc->activity, $doc->society, $doc->type, $doc->id]) }}" 
                                                   class="btn btn-outline-primary" 
                                                   title="Voir le PDF">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                
                                                <!-- Prévisualiser -->
                                                <a href="{{ route('back.document.preview', [$doc->activity, $doc->society, $doc->type, $doc->id]) }}" 
                                                   target="_blank" 
                                                   class="btn btn-outline-info" 
                                                   title="Prévisualiser">
                                                    <i class="fa fa-file-alt"></i>
                                                </a>
                                                
                                                <!-- Modifier -->
                                                <a href="{{ route('back.document.edit', [$doc->activity, $doc->society, $doc->type, $doc->id]) }}" 
                                                   class="btn btn-outline-warning" 
                                                   title="Modifier">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                
                                                <!-- Actions selon le type -->
                                                @if($doc->type === 'devis')
                                                    <!-- Créer facture depuis devis -->
                                                    <a href="{{ route('back.document.facture.create', [$doc->activity, $doc->society, $doc->id]) }}" 
                                                       class="btn btn-outline-success" 
                                                       title="Créer facture">
                                                        <i class="fa fa-file-invoice"></i>
                                                    </a>
                                                    
                                                    <!-- Créer attestation depuis devis -->
                                                    <div class="btn-group">
                                                        <button type="button" 
                                                                class="btn btn-outline-secondary dropdown-toggle" 
                                                                data-bs-toggle="dropdown" 
                                                                title="Créer attestation">
                                                            <i class="fa fa-certificate"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" 
                                                                   href="{{ route('back.document.attestation.create', [$doc->activity, $doc->society, $doc->id]) }}">
                                                                    Attestation réalisation
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" 
                                                                   href="{{ route('back.document.attestation-signataire.create', [$doc->activity, $doc->society, $doc->id]) }}">
                                                                    Attestation signataire
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($documents->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Affichage de {{ $documents->firstItem() }} à {{ $documents->lastItem() }} sur {{ $documents->total() }} résultats
                            </div>
                            <div>
                                {{ $documents->withQueryString()->links() }}
                            </div>
                        </div>
                        @endif
                    @else
                        <!-- Aucun document -->
                        <div class="text-center py-5">
                            <i class="fa fa-file-alt fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun document trouvé</h5>
                            <p class="text-muted mb-4">
                                @if($type === 'all')
                                Aucun document n'a été créé pour cette activité et société.
                                @else
                                Aucun {{ $type }} n'a été créé pour cette activité et société.
                                @endif
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('back.document.create', [$activity, $society, 'devis']) }}" 
                                   class="btn btn-primary">
                                    <i class="fa fa-plus me-2"></i>Créer un devis
                                </a>
                                <a href="{{ route('back.documents.creation-rapide') }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fa fa-bolt me-2"></i>Création rapide
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">Actions rapides</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <a href="{{ route('back.document.create', [$activity, $society, 'devis']) }}" 
                               class="btn btn-outline-info w-100">
                                <i class="fa fa-file-contract me-2"></i>Nouveau devis
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('back.document.create', [$activity, $society, 'facture']) }}" 
                               class="btn btn-outline-success w-100">
                                <i class="fa fa-file-invoice me-2"></i>Nouvelle facture
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('back.document.create', [$activity, $society, 'rapport']) }}" 
                               class="btn btn-outline-warning w-100">
                                <i class="fa fa-chart-bar me-2"></i>Nouveau rapport
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('back.dashboard', [$activity, $society]) }}" 
                               class="btn btn-outline-primary w-100">
                                <i class="fa fa-tachometer-alt me-2"></i>Tableau de bord
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@foreach($documents as $document)
<tr>
    <td>{{ $document->reference_devis ?? $document->id }}</td>
    <td>{{ $document->type }}</td>
    <td>{{ $document->created_at->format('d/m/Y') }}</td>
    <td>
        @if($document->pdf_path)
            <a href="{{ Storage::url($document->pdf_path) }}" 
               target="_blank"
               class="btn btn-sm btn-info">
               <i class="fa fa-eye"></i>
            </a>
            <a href="{{ route('back.document.download', [$document->activity, $document->society, $document->type, $document->id]) }}"
               class="btn btn-sm btn-success">
               <i class="fa fa-download"></i>
            </a>
        @else
            <span class="badge bg-warning">PDF non généré</span>
        @endif
    </td>
</tr>
@endforeach
@endsection

@push('styles')
<style>
.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}
.badge {
    font-size: 0.8em;
    font-weight: 500;
}
.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
// Confirmation avant suppression
document.addEventListener('DOMContentLoaded', function() {
    // Filtre de recherche automatique
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    }
    
    // Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush