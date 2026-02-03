












@extends('back.layouts.principal')

@section('title', 'Nouvelle Activité')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-secondary rounded p-4">
                <!-- En-tête -->
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('back.activites.index') }}" class="btn btn-outline-light btn-sm me-3"> {{-- CORRECTION: activites.index --}}
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h4 class="mb-0 text-white">
                            <i class="fas fa-tasks me-2 text-primary"></i>Nouvelle Activité
                        </h4>
                        <small class="text-muted">Créez un nouveau type d'intervention</small>
                    </div>
                </div>

                <!-- Formulaire -->
                <form action="{{ route('back.activites.store') }}" method="POST"> {{-- CORRECTION: activites.store --}}
                    @csrf
                    
                    <!-- Nom -->
                    <div class="mb-3">
                        <label for="nom" class="form-label text-white">Nom de l'activité <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" 
                               name="nom" 
                               value="{{ old('nom') }}" 
                               placeholder="Ex: Désembouage" 
                               required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-white-50">Nom descriptif de l'activité</div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label text-white">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  placeholder="Description détaillée de l'activité...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Code (optionnel) -->
                    <div class="mb-3">
                        <label for="code" class="form-label text-white">Code</label>
                        <input type="text" 
                               class="form-control @error('code') is-invalid @enderror" 
                               id="code" 
                               name="code" 
                               value="{{ old('code') }}" 
                               placeholder="Généré automatiquement">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-white-50">Identifiant unique (laisser vide pour auto-génération)</div>
                    </div>

                    <!-- Apparence -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <!-- Couleur -->
                            <div class="mb-3">
                                <label for="couleur" class="form-label text-white">Couleur</label>
                                <div class="d-flex align-items-center">
                                    <input type="color" 
                                           class="form-control form-control-color @error('couleur') is-invalid @enderror" 
                                           id="couleur" 
                                           name="couleur" 
                                           value="{{ old('couleur', '#3B82F6') }}"
                                           style="width: 60px; height: 60px; border-radius: 50%;">
                                    <div class="ms-3">
                                        <div class="color-preview rounded p-2" 
                                             style="background-color: {{ old('couleur', '#3B82F6') }}; width: 40px; height: 40px;"></div>
                                    </div>
                                </div>
                                @error('couleur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-white-50">Couleur d'identification</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Icône -->
                            <div class="mb-3">
                                <label for="icon" class="form-label text-white">Icône</label>
                                <select class="form-select @error('icon') is-invalid @enderror" 
                                        id="icon" 
                                        name="icon">
                                    @foreach($icones as $value => $label)
                                        <option value="{{ $value }}" 
                                                {{ old('icon', 'fa-wrench') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2 text-center">
                                    <div class="icon-preview d-inline-block p-3 rounded"
                                         style="background-color: {{ old('couleur', '#3B82F6') }};">
                                        <i class="{{ old('icon', 'fa-wrench') }} fa-2x text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statut -->
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="est_active" 
                                   name="est_active" 
                                   value="1" 
                                   {{ old('est_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label text-white fw-bold" for="est_active">
                                Activité active
                            </label>
                        </div>
                        <div class="form-text text-white-50">Désactivez pour masquer cette activité</div>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('back.activites.index') }}" class="btn btn-outline-light"> {{-- CORRECTION: activites.index --}}
                            <i class="fas fa-times me-1"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Créer l'activité
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
    // Mise à jour dynamique de la couleur de prévisualisation
    $('#couleur').on('input', function() {
        const color = $(this).val();
        $('.color-preview').css('background-color', color);
        $('.icon-preview').css('background-color', color);
    });

    // Mise à jour dynamique de l'icône
    $('#icon').on('change', function() {
        const iconClass = $(this).val();
        $('.icon-preview i').removeClass().addClass(iconClass + ' fa-2x text-white');
    });

    // Génération automatique du code à partir du nom
    $('#nom').on('blur', function() {
        if ($('#code').val() === '') {
            const nom = $(this).val();
            if (nom.trim() !== '') {
                // Créer un slug simple
                const slug = nom.toLowerCase()
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Enlève les accents
                    .replace(/[^a-z0-9]/g, '-') // Remplace tout ce qui n'est pas alphanumérique par -
                    .replace(/-+/g, '-') // Remplace les tirets multiples par un seul
                    .replace(/^-|-$/g, ''); // Enlève les tirets en début et fin
                
                $('#code').val(slug);
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.color-preview {
    transition: all 0.3s ease;
}

.icon-preview {
    transition: all 0.3s ease;
    min-width: 80px;
}

.form-control-color {
    cursor: pointer;
}

.form-control-color:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>
@endpush