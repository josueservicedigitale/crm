@extends('back.layouts.principal')

@section('title', 'Paramètres')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <i class="fas fa-cog me-2"></i>Paramètres
                </h1>
                <div class="btn-group">
                    <a href="{{ route('back.parametres.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nouveau paramètre
                    </a>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#aideModal">
                        <i class="fas fa-question-circle me-2"></i>Aide
                    </button>
                </div>
            </div>
            <p class="text-muted">Gérez les paramètres généraux de l'application.</p>
        </div>
    </div>

    <!-- Navigation par groupes -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                @forelse($groupes as $groupe)
                <a href="{{ route('back.parametres.index', ['groupe' => $groupe]) }}" 
                   class="btn btn-sm {{ $groupeActif == $groupe ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-folder me-1"></i>{{ ucfirst($groupe) }}
                </a>
                @empty
                <span class="text-muted">Aucun groupe trouvé</span>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Formulaire de mise à jour en masse -->
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-sliders-h me-2"></i>
                Paramètres : {{ ucfirst($groupeActif) }}
            </h5>
            <div>
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#restaurerModal">
                    <i class="fas fa-redo me-1"></i>Restaurer défauts
                </button>
            </div>
        </div>
        <div class="card-body">
            @if($parametres->count() > 0)
            <form method="POST" action="{{ route('back.parametres.update-masse') }}">
                @csrf
                
                <div class="row">
                    @foreach($parametres as $parametre)
                    <div class="col-md-6 mb-4">
                        <div class="border rounded p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-semibold mb-0">
                                    {{ $parametre->titre }}
                                    @if($parametre->est_systeme)
                                    <span class="badge bg-warning ms-2" data-bs-toggle="tooltip" title="Paramètre système non modifiable">
                                        <i class="fas fa-lock me-1"></i>Système
                                    </span>
                                    @endif
                                </h6>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           name="est_actif_{{ $parametre->id }}" 
                                           id="est_actif_{{ $parametre->id }}" 
                                           value="1" 
                                           {{ $parametre->est_actif ? 'checked' : '' }}
                                           {{ $parametre->est_systeme ? 'disabled' : '' }}
                                           onchange="this.form.submit()">
                                    <label class="form-check-label" for="est_actif_{{ $parametre->id }}">
                                        <small>Actif</small>
                                    </label>
                                </div>
                            </div>
                            
                            @if($parametre->description)
                            <p class="text-muted small mb-3">
                                <i class="fas fa-info-circle me-1"></i>
                                {{ $parametre->description }}
                            </p>
                            @endif
                            
                            <!-- Champ selon le type -->
                            @if($parametre->est_systeme)
                            <div class="alert alert-info py-2 mb-0">
                                <small>
                                    <i class="fas fa-lock me-1"></i>
                                    Valeur système : 
                                    <code class="bg-light p-1 rounded">{{ $parametre->valeur }}</code>
                                </small>
                            </div>
                            @else
                            <div class="mt-3">
                                @switch($parametre->type)
                                    @case('boolean')
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                               name="{{ $parametre->cle }}" 
                                               id="{{ $parametre->cle }}" 
                                               value="1" 
                                               {{ $parametre->valeur == '1' ? 'checked' : '' }}
                                               onchange="this.form.submit()">
                                        <label class="form-check-label" for="{{ $parametre->cle }}">
                                            {{ $parametre->valeur == '1' ? 'Activé' : 'Désactivé' }}
                                        </label>
                                    </div>
                                    @break
                                    
                                    @case('select')
                                    <select class="form-select" name="{{ $parametre->cle }}" 
                                            id="{{ $parametre->cle }}" onchange="this.form.submit()">
                                        @if($parametre->options)
                                            @foreach(json_decode($parametre->options, true) as $value => $label)
                                            <option value="{{ $value }}" {{ $parametre->valeur == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @break
                                    
                                    @case('text')
                                    <textarea class="form-control" name="{{ $parametre->cle }}" 
                                              id="{{ $parametre->cle }}" rows="3"
                                              placeholder="Entrez la valeur...">{{ $parametre->valeur }}</textarea>
                                    @break
                                    
                                    @case('email')
                                    <input type="email" class="form-control" 
                                           name="{{ $parametre->cle }}" 
                                           id="{{ $parametre->cle }}" 
                                           value="{{ $parametre->valeur }}"
                                           placeholder="exemple@domaine.com">
                                    @break
                                    
                                    @case('url')
                                    <input type="url" class="form-control" 
                                           name="{{ $parametre->cle }}" 
                                           id="{{ $parametre->cle }}" 
                                           value="{{ $parametre->valeur }}"
                                           placeholder="https://exemple.com">
                                    @break
                                    
                                    @case('integer')
                                    <input type="number" class="form-control" 
                                           name="{{ $parametre->cle }}" 
                                           id="{{ $parametre->cle }}" 
                                           value="{{ $parametre->valeur }}"
                                           step="1">
                                    @break
                                    
                                    @case('float')
                                    <input type="number" class="form-control" 
                                           name="{{ $parametre->cle }}" 
                                           id="{{ $parametre->cle }}" 
                                           value="{{ $parametre->valeur }}"
                                           step="0.01">
                                    @break
                                    
                                    @default
                                    <input type="text" class="form-control" 
                                           name="{{ $parametre->cle }}" 
                                           id="{{ $parametre->cle }}" 
                                           value="{{ $parametre->valeur }}"
                                           placeholder="Entrez la valeur...">
                                @endswitch
                            </div>
                            @endif
                            
                            <!-- Informations supplémentaires -->
                            <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-key me-1"></i>
                                        <code>{{ $parametre->cle }}</code>
                                    </small>
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-tag me-1"></i>
                                        Type: {{ ucfirst($parametre->type) }}
                                    </small>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('back.parametres.show', $parametre) }}" 
                                       class="btn btn-outline-info" 
                                       data-bs-toggle="tooltip" 
                                       title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('back.parametres.edit', $parametre) }}" 
                                       class="btn btn-outline-primary"
                                       data-bs-toggle="tooltip" 
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$parametre->est_systeme)
                                    <button type="button" class="btn btn-outline-danger" 
                                            onclick="confirmerSuppression('{{ route('back.parametres.destroy', $parametre) }}')"
                                            data-bs-toggle="tooltip" 
                                            title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Boutons d'action -->
                <div class="mt-4 pt-4 border-top">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-lightbulb me-1"></i>
                                Les modifications sont automatiquement sauvegardées pour les switches
                            </small>
                        </div>
                        <div class="btn-group">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo me-2"></i>Réinitialiser
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer tout
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            @else
            <div class="text-center py-5">
                <i class="fas fa-cogs fa-4x text-muted mb-3"></i>
                <h4>Aucun paramètre dans ce groupe</h4>
                <p class="text-muted">Commencez par créer votre premier paramètre.</p>
                <a href="{{ route('back.parametres.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Créer un paramètre
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Aide -->
<div class="modal fade" id="aideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-question-circle me-2"></i>Aide - Paramètres
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>📋 Types de paramètres :</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Exemple</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Texte court</td><td>Pour les champs courts</td><td>Nom, titre, email</td></tr>
                            <tr><td>Texte long</td><td>Pour les descriptions</td><td>Description, notes</td></tr>
                            <tr><td>Nombre entier</td><td>Sans décimales</td><td>Jours, compteurs</td></tr>
                            <tr><td>Nombre décimal</td><td>Avec décimales</td><td>TVA, montants</td></tr>
                            <tr><td>Oui/Non</td><td>Booléen</td><td>Activer/Désactiver</td></tr>
                            <tr><td>Liste déroulante</td><td>Choix multiples</td><td>Options prédéfinies</td></tr>
                        </tbody>
                    </table>
                </div>
                
                <h6 class="mt-4">🎯 Conseils d'utilisation :</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Utilisez des clés descriptives (ex: "nom_application", "jours_conservation")</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Les paramètres système sont protégés contre les modifications</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Toutes les modifications sont mises en cache pour de meilleures performances</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Vous pouvez restaurer les paramètres par défaut à tout moment</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Restaurer -->
<div class="modal fade" id="restaurerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Restaurer les paramètres par défaut
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h6 class="alert-heading">⚠️ Attention ! Action irréversible</h6>
                    <p class="mb-0">
                        Vous êtes sur le point de restaurer tous les paramètres à leurs valeurs par défaut.
                    </p>
                    <hr>
                    <p class="mb-0">
                        <strong>Conséquences :</strong>
                    </p>
                    <ul class="mt-2 mb-0">
                        <li>Tous les paramètres personnalisés seront perdus</li>
                        <li>Les paramètres système seront préservés</li>
                        <li>L'application utilisera les valeurs par défaut</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="{{ route('back.parametres.restaurer-defauts') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-redo me-2"></i>Restaurer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Initialiser les tooltips Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Confirmation de suppression
function confirmerSuppression(url) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce paramètre ? Cette action est irréversible.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.style.display = 'none';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        
        form.appendChild(csrf);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
}

// Auto-submit pour les champs avec délai
let timeoutId;
document.querySelectorAll('input:not(.form-check-input), select, textarea').forEach(element => {
    element.addEventListener('change', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            this.form.submit();
        }, 1000);
    });
});
</script>
@endsection