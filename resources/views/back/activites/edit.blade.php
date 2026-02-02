@extends('back.layouts.principal')

@section('title', 'Modifier Activité')

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
                        <h4 class="mb-0">✏️ Modifier {{ $activite->nom }}</h4>
                        <small class="text-muted">Modifiez les informations de l'activité</small>
                    </div>
                    <div class="ms-auto">
                        <span class="badge {{ $activite->est_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $activite->est_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                
                <!-- Formulaire -->
                <form action="{{ route('back.activites.update', $activite) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Aperçu -->
                    <div class="card bg-dark mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-3 me-3" 
                                     style="background-color: {{ $activite->couleur }};">
                                    <i class="{{ $activite->icon }} fa-2x text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $activite->nom }}</h5>
                                    <p class="mb-0 text-muted">{{ $activite->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Nom de l'activité -->
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom *</label>
                            <input type="text" 
                                   class="form-control bg-dark text-white @error('nom') is-invalid @enderror" 
                                   id="nom" 
                                   name="nom" 
                                   value="{{ old('nom', $activite->nom) }}" 
                                   required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Code unique -->
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">Code *</label>
                            <input type="text" 
                                   class="form-control bg-dark text-white @error('code') is-invalid @enderror" 
                                   id="code" 
                                   name="code" 
                                   value="{{ old('code', $activite->code) }}" 
                                   required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control bg-dark text-white @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3">{{ old('description', $activite->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <!-- Couleur -->
                        <div class="col-md-6 mb-3">
                            <label for="couleur" class="form-label">Couleur</label>
                            <div class="input-group">
                                <input type="color" 
                                       class="form-control form-control-color bg-dark" 
                                       id="couleur" 
                                       name="couleur" 
                                       value="{{ old('couleur', $activite->couleur) }}">
                                <span class="input-group-text bg-dark text-white">Pré-définies :</span>
                                <div class="d-flex align-items-center px-2">
                                    @foreach($couleurs as $valeur => $nom)
                                    <div class="color-option me-2" 
                                         style="width: 20px; height: 20px; background-color: {{ $valeur }}; border-radius: 3px; cursor: pointer;"
                                         data-color="{{ $valeur }}"></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Icône -->
                        <div class="col-md-6 mb-3">
                            <label for="icon" class="form-label">Icône</label>
                            <select class="form-select bg-dark text-white @error('icon') is-invalid @enderror" 
                                    id="icon" 
                                    name="icon">
                                @foreach($icones as $valeur => $nom)
                                <option value="{{ $valeur }}" {{ old('icon', $activite->icon) == $valeur ? 'selected' : '' }}>
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
                                   {{ old('est_active', $activite->est_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="est_active">
                                Activer cette activité
                            </label>
                        </div>
                    </div>
                    
                    <!-- Informations -->
                    <div class="card bg-dark mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <small class="text-muted">Créée le</small>
                                    <p class="mb-0">{{ $activite->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Documents</small>
                                    <p class="mb-0">
                                        <span class="badge bg-info">{{ $activite->documents_count }}</span>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Créée par</small>
                                    <p class="mb-0">{{ $activite->user->name ?? 'Inconnu' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Boutons -->
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('back.activites.index') }}" class="btn btn-outline-light me-2">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            @if($activite->documents_count == 0)
                            <button type="button" 
                                    class="btn btn-outline-danger delete-btn"
                                    data-id="{{ $activite->id }}"
                                    data-nom="{{ $activite->nom }}">
                                <i class="fas fa-trash me-2"></i>Supprimer
                            </button>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer
                        </button>
                    </div>
                </form>
                
                <!-- Formulaire de suppression caché -->
                <form id="delete-form-{{ $activite->id }}" 
                      action="{{ route('back.activites.destroy', $activite) }}" 
                      method="POST" 
                      style="display: none;">
                    @csrf
                    @method('DELETE')
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
    
    // Suppression
    $('.delete-btn').on('click', function() {
        const activiteId = $(this).data('id');
        const activiteNom = $(this).data('nom');
        
        Swal.fire({
            title: 'Confirmer la suppression',
            html: `Êtes-vous sûr de vouloir supprimer l'activité <strong>"${activiteNom}"</strong> ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#delete-form-${activiteId}`).submit();
            }
        });
    });
});
</script>
@endpush