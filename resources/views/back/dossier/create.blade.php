@extends('back.layouts.principal')

@section('title', 'Nouveau dossier')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bg-white rounded shadow-sm p-5">
                <!-- En-tête -->
                <div class="text-center mb-5">
                    <i class="fas fa-folder-plus fa-4x text-primary mb-3"></i>
                    <h2 class="fw-bold">Créer un nouveau dossier</h2>
                    <p class="text-muted">Organisez vos documents dans des dossiers structurés</p>
                </div>

                <!-- Formulaire -->
                <form action="{{ route('back.dossiers.store') }}" method="POST">
                    @csrf
                    
                    @if($parent)
                        <input type="hidden" name="parent_id" value="{{ $parent->id }}">
                    @endif

                    <!-- Nom du dossier -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-folder me-2 text-primary"></i>
                            Nom du dossier <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('nom') is-invalid @enderror" 
                               name="nom" 
                               value="{{ old('nom') }}"
                               placeholder="Ex: Factures 2024, Documents techniques, ..."
                               required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-align-left me-2 text-primary"></i>
                            Description (optionnelle)
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  name="description" 
                                  rows="3"
                                  placeholder="Décrivez le contenu ou l'utilité de ce dossier...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Société et Activité -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="fas fa-building me-2 text-primary"></i>
                                Société associée
                            </label>
                            <select name="societe_id" class="form-select @error('societe_id') is-invalid @enderror">
                                <option value="">Aucune société</option>
                                @foreach($societes as $societe)
                                    <option value="{{ $societe->id }}" {{ old('societe_id') == $societe->id ? 'selected' : '' }}>
                                        {{ $societe->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Optionnel - Liez ce dossier à une société</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="fas fa-tasks me-2 text-primary"></i>
                                Activité associée
                            </label>
                            <select name="activite_id" class="form-select @error('activite_id') is-invalid @enderror">
                                <option value="">Aucune activité</option>
                                @foreach($activites as $activite)
                                    <option value="{{ $activite->id }}" {{ old('activite_id') == $activite->id ? 'selected' : '' }}>
                                        {{ $activite->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Optionnel - Liez ce dossier à une activité</small>
                        </div>
                    </div>

                    <!-- Visibilité -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-globe me-2 text-primary"></i>
                            Visibilité
                        </label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="est_visible" 
                                   id="est_visible" 
                                   value="1"
                                   {{ old('est_visible') ? 'checked' : '' }}>
                            <label class="form-check-label" for="est_visible">
                                <span class="fw-bold">Dossier public</span>
                                <br>
                                <small class="text-muted">
                                    Si activé, ce dossier sera visible par tous les utilisateurs
                                </small>
                            </label>
                        </div>
                    </div>

                    <!-- Personnalisation -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="fas fa-palette me-2 text-primary"></i>
                                Couleur
                            </label>
                            <input type="color" 
                                   class="form-control form-control-color" 
                                   name="couleur" 
                                   value="{{ old('couleur', '#0d6efd') }}"
                                   title="Choisir une couleur">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="fas fa-icons me-2 text-primary"></i>
                                Icône
                            </label>
                            <select name="icon" class="form-select">
                                <option value="fa-folder" {{ old('icon') == 'fa-folder' ? 'selected' : '' }}>📁 Dossier</option>
                                <option value="fa-folder-open" {{ old('icon') == 'fa-folder-open' ? 'selected' : '' }}>📂 Dossier ouvert</option>
                                <option value="fa-file-pdf" {{ old('icon') == 'fa-file-pdf' ? 'selected' : '' }}>📄 PDF</option>
                                <option value="fa-file-invoice" {{ old('icon') == 'fa-file-invoice' ? 'selected' : '' }}>📋 Factures</option>
                                <option value="fa-file-signature" {{ old('icon') == 'fa-file-signature' ? 'selected' : '' }}>✍️ Devis</option>
                            </select>
                        </div>
                    </div>

                    @if($parent)
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            Ce dossier sera créé dans : <strong>{{ $parent->chemin_complet }}</strong>
                        </div>
                    @endif

                    <!-- Boutons -->
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ $parent ? route('back.dossiers.show', $parent->slug) : route('back.dossiers.index') }}" 
                           class="btn btn-outline-secondary btn-lg px-5">
                            <i class="fas fa-times me-2"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-check me-2"></i>Créer le dossier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection