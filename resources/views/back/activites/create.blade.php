@extends('back.layouts.principal')

@section('title', 'Nouvelle Activité')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-secondary rounded p-4">
                <!-- En-tête -->
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('back.activites.index') }}" class="btn btn-outline-light btn-sm me-3">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h4 class="mb-0">➕ Nouvelle Activité</h4>
                        <small class="text-muted">Ajoutez un nouveau type d'intervention</small>
                    </div>
                </div>
                
                <!-- Formulaire -->
                <form action="{{ route('back.activites.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Nom de l'activité -->
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nom de l'activité *
                            </label>
                            <input type="text" 
                                   class="form-control bg-dark text-white @error('nom') is-invalid @enderror" 
                                   id="nom" 
                                   name="nom" 
                                   value="{{ old('nom') }}" 
                                   placeholder="Ex: Désembouage" 
                                   required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Nom complet de l'activité</small>
                        </div>
                        
                        <!-- Code unique -->
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">
                                <i class="fas fa-code me-2"></i>Code unique *
                            </label>
                            <input type="text" 
                                   class="form-control bg-dark text-white @error('code') is-invalid @enderror" 
                                   id="code" 
                                   name="code" 
                                   value="{{ old('code') }}" 
                                   placeholder="Ex: desembouage" 
                                   required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Code utilisé dans les documents (minuscules, sans espaces)</small>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-2"></i>Description
                        </label>
                        <textarea class="form-control bg-dark text-white @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  placeholder="Description détaillée de l'activité...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <!-- Couleur -->
                        <div class="col-md-6 mb-3">
                            <label for="couleur" class="form-label">
                                <i class="fas fa-palette me-2"></i>Couleur
                            </label>
                            <div class="input-group">
                                <input type="color" 
                                       class="form-control form-control-color bg-dark" 
                                       id="couleur" 
                                       name="couleur" 
                                       value="{{ old('couleur', '#3B82F6') }}"
                                       title="Choisir une couleur">
                                <span class="input-group-text bg-dark text-white">Pré-définies :</span>
                                <div class="d-flex align-items-center px-2">
                                    @foreach($couleurs as $valeur => $nom)
                                    <div class="color-option me-2" 
                                         style="width: 20px; height: 20px; background-color: {{ $valeur }}; border-radius: 3px; cursor: pointer;"
                                         data-color="{{ $valeur }}"
                                         title="{{ $nom }}"></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Icône -->
                        <div class="col-md-6 mb-3">
                            <label for="icon" class="form-label">
                                <i class="fas fa-icons me-2"></i>Icône
                            </label>
                            <select class="form-select bg-dark text-white @error('icon') is-invalid @enderror" 
                                    id="icon" 
                                    name="icon">
                                @foreach($icones as $valeur => $nom)
                                <option value="{{ $valeur }}" {{ old('icon', 'fa-tools') == $valeur ? 'selected' : '' }}>
                                    <i class="{{ $valeur }} me-2"></i>{{ $nom }}
                                </option>
                                @endforeach
                            </select>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Statut -->
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   role="switch" 
                                   id="est_active" 
                                   name="est_active" 
                                   {{ old('est_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="est_active">
                                <i class="fas fa-power-off me-2"></i>Activer immédiatement cette activité
                            </label>
                            <small class="d-block text-muted mt-1">
                                Si activé, l'activité sera disponible dans les formulaires de documents.
                            </small>
                        </div>
                    </div>
                    
                    <!-- Boutons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('back.activites.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-times me-2"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Créer l'activité
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Sélection de couleur
    $('.color-option').on('click', function() {
        const couleur = $(this).data('color');
        $('#couleur').val(couleur);
    });
    
    // Style pour le switch
    $('#est_active').on('change', function() {
        const label = $(this).next('.form-check-label');
        if ($(this).is(':checked')) {
            label.find('i').css('color', '#0d6efd');
        } else {
            label.find('i').css('color', '#6c757d');
        }
    });
});
</script>
@endpush