@extends('back.layouts.principal')

@section('title', 'Créer un paramètre')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Créer un nouveau paramètre
                </h1>
                <a href="{{ route('back.parametres.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Informations du paramètre</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('back.parametres.store') }}">
                        @csrf

                        <div class="row">
                            <!-- Clé unique -->
                            <div class="col-md-6 mb-3">
                                <label for="cle" class="form-label fw-semibold">
                                    Clé unique <span class="text-danger">*</span>
                                    <i class="fas fa-info-circle ms-1" 
                                       data-bs-toggle="tooltip" 
                                       title="Identifiant unique du paramètre (ex: nom_application, theme_couleur)"></i>
                                </label>
                                <input type="text" 
                                       class="form-control @error('cle') is-invalid @enderror" 
                                       id="cle" 
                                       name="cle" 
                                       value="{{ old('cle') }}"
                                       placeholder="ex: jours_conservation_corbeille"
                                       required>
                                <small class="text-muted">Uniquement lettres minuscules, chiffres et underscores</small>
                                @error('cle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Titre -->
                            <div class="col-md-6 mb-3">
                                <label for="titre" class="form-label fw-semibold">
                                    Titre <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('titre') is-invalid @enderror" 
                                       id="titre" 
                                       name="titre" 
                                       value="{{ old('titre') }}"
                                       placeholder="ex: Jours de conservation corbeille"
                                       required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12 mb-3">
                                <label for="description" class="form-label fw-semibold">
                                    Description
                                    <i class="fas fa-info-circle ms-1" 
                                       data-bs-toggle="tooltip" 
                                       title="Description détaillée du paramètre"></i>
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="2"
                                          placeholder="Décrivez l'utilité de ce paramètre...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Groupe -->
                            <div class="col-md-6 mb-3">
                                <label for="groupe" class="form-label fw-semibold">
                                    Groupe <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <select class="form-select @error('groupe') is-invalid @enderror" 
                                            id="groupe" 
                                            name="groupe" 
                                            required>
                                        <option value="">Sélectionnez un groupe</option>
                                        @foreach($tousGroupes as $groupe)
                                            <option value="{{ $groupe }}" {{ old('groupe') == $groupe ? 'selected' : '' }}>
                                                {{ ucfirst($groupe) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-secondary" type="button" 
                                            data-bs-toggle="modal" data-bs-target="#nouveauGroupeModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                @error('groupe')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label fw-semibold">
                                    Type de donnée <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('type') is-invalid @enderror" 
                                        id="type" 
                                        name="type" 
                                        required
                                        onchange="toggleOptionsField()">
                                    <option value="">Sélectionnez un type</option>
                                    @foreach($types as $value => $label)
                                        <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : ($loop->first ? 'selected' : '') }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Valeur -->
                            <div class="col-12 mb-3">
                                <label for="valeur" class="form-label fw-semibold">
                                    Valeur par défaut
                                    <i class="fas fa-info-circle ms-1" 
                                       data-bs-toggle="tooltip" 
                                       title="Valeur initiale du paramètre"></i>
                                </label>
                                <div id="valeur-container">
                                    <input type="text" class="form-control" 
                                           id="valeur" 
                                           name="valeur" 
                                           value="{{ old('valeur') }}"
                                           placeholder="Entrez la valeur par défaut...">
                                </div>
                                @error('valeur')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Options (pour select) -->
                            <div class="col-12 mb-3" id="options-container" style="display: none;">
                                <label for="options" class="form-label fw-semibold">
                                    Options de la liste
                                    <i class="fas fa-info-circle ms-1" 
                                       data-bs-toggle="tooltip" 
                                       title="Format JSON: {\"valeur1\":\"Label1\",\"valeur2\":\"Label2\"}"></i>
                                </label>
                                <textarea class="form-control @error('options') is-invalid @enderror" 
                                          id="options" 
                                          name="options" 
                                          rows="3"
                                          placeholder='{"option1": "Option 1", "option2": "Option 2"}'>{{ old('options') }}</textarea>
                                <small class="text-muted">Format JSON requis pour les listes déroulantes</small>
                                @error('options')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ordre -->
                            <div class="col-md-6 mb-3">
                                <label for="ordre" class="form-label fw-semibold">
                                    Ordre d'affichage
                                </label>
                                <input type="number" 
                                       class="form-control @error('ordre') is-invalid @enderror" 
                                       id="ordre" 
                                       name="ordre" 
                                       value="{{ old('ordre', 0) }}"
                                       min="0"
                                       step="1">
                                <small class="text-muted">Plus le nombre est petit, plus il apparaît en premier</small>
                                @error('ordre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" 
                                               name="est_actif" 
                                               id="est_actif" 
                                               value="1" 
                                               {{ old('est_actif', true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="est_actif">
                                            Actif
                                        </label>
                                    </div>
                                    <small class="text-muted">Si désactivé, le paramètre ne sera pas accessible</small>
                                </div>
                            </div>

                            <!-- Système -->
                            <div class="col-12 mb-3">
                                <div class="border rounded p-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="est_systeme" 
                                               id="est_systeme" 
                                               value="1" 
                                               {{ old('est_systeme') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="est_systeme">
                                            <i class="fas fa-lock me-1"></i>Paramètre système
                                        </label>
                                        <div class="mt-1">
                                            <small class="text-warning">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Les paramètres système ne peuvent pas être modifiés ni supprimés
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('back.parametres.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer le paramètre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar d'aide -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Conseils</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">📝 Nommage des clés</h6>
                        <p class="mb-0 small">Utilisez des noms explicites en minuscules avec underscores :</p>
                        <code class="d-block mt-2 p-2 bg-light">nom_application</code>
                        <code class="d-block mt-1 p-2 bg-light">jours_conservation</code>
                        <code class="d-block mt-1 p-2 bg-light">theme_couleur</code>
                    </div>

                    <div class="alert alert-success mt-3">
                        <h6 class="alert-heading">🎯 Exemples d'utilisation</h6>
                        <p class="mb-0 small">Dans vos vues :</p>
                        <pre class="mt-2 p-2 bg-light small"><code>@verbatim{{ parametre("nom_application") }}@endverbatim</code></pre>
                        <p class="mb-0 small">Dans vos contrôleurs :</p>
                        <pre class="mt-2 p-2 bg-light small"><code>parametre('jours_conservation', 30);</code></pre>
                    </div>

                    <div class="alert alert-warning mt-3">
                        <h6 class="alert-heading">⚠️ Important</h6>
                        <p class="mb-0 small">
                            Une fois créé, un paramètre peut être modifié à tout moment.
                            Les paramètres système sont réservés aux développeurs.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nouveau Groupe -->
<div class="modal fade" id="nouveauGroupeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-folder-plus me-2"></i>Nouveau groupe
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nouveau_groupe" class="form-label fw-semibold">
                        Nom du groupe
                    </label>
                    <input type="text" class="form-control" id="nouveau_groupe" 
                           placeholder="ex: facturation, notifications">
                    <small class="text-muted">Lettres minuscules uniquement</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="ajouterGroupe()">
                    <i class="fas fa-plus me-2"></i>Ajouter
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Afficher/masquer le champ options selon le type
function toggleOptionsField() {
    const type = document.getElementById('type').value;
    const optionsContainer = document.getElementById('options-container');
    const valeurContainer = document.getElementById('valeur-container');
    
    if (type === 'select') {
        optionsContainer.style.display = 'block';
    } else {
        optionsContainer.style.display = 'none';
    }
    
    // Adapter le champ valeur selon le type
    if (valeurContainer) {
        let inputHtml = '';
        switch(type) {
            case 'boolean':
                inputHtml = `
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="valeur" id="valeur" value="1">
                        <label class="form-check-label" for="valeur">Actif par défaut</label>
                    </div>`;
                break;
            case 'integer':
                inputHtml = `<input type="number" class="form-control" id="valeur" name="valeur" value="{{ old('valeur') }}" step="1">`;
                break;
            case 'float':
                inputHtml = `<input type="number" class="form-control" id="valeur" name="valeur" value="{{ old('valeur') }}" step="0.01">`;
                break;
            case 'email':
                inputHtml = `<input type="email" class="form-control" id="valeur" name="valeur" value="{{ old('valeur') }}" placeholder="exemple@domaine.com">`;
                break;
            case 'url':
                inputHtml = `<input type="url" class="form-control" id="valeur" name="valeur" value="{{ old('valeur') }}" placeholder="https://exemple.com">`;
                break;
            case 'text':
                inputHtml = `<textarea class="form-control" id="valeur" name="valeur" rows="3">{{ old('valeur') }}</textarea>`;
                break;
            default:
                inputHtml = `<input type="text" class="form-control" id="valeur" name="valeur" value="{{ old('valeur') }}">`;
        }
        valeurContainer.innerHTML = inputHtml;
    }
}

// Ajouter un nouveau groupe
function ajouterGroupe() {
    const nouveauGroupe = document.getElementById('nouveau_groupe').value.trim().toLowerCase();
    
    if (!nouveauGroupe) {
        alert('Veuillez entrer un nom de groupe');
        return;
    }
    
    // Vérifier format (lettres et underscores uniquement)
    if (!/^[a-z_]+$/.test(nouveauGroupe)) {
        alert('Le groupe ne doit contenir que des lettres minuscules et des underscores');
        return;
    }
    
    // Ajouter au select
    const select = document.getElementById('groupe');
    const option = document.createElement('option');
    option.value = nouveauGroupe;
    option.textContent = nouveauGroupe.charAt(0).toUpperCase() + nouveauGroupe.slice(1);
    option.selected = true;
    select.appendChild(option);
    
    // Fermer le modal
    bootstrap.Modal.getInstance(document.getElementById('nouveauGroupeModal')).hide();
    
    // Vider le champ
    document.getElementById('nouveau_groupe').value = '';
}

// Initialiser au chargement
document.addEventListener('DOMContentLoaded', function() {
    toggleOptionsField();
});
</script>
@endsection