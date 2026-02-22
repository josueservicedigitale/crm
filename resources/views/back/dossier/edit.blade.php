@extends('back.layouts.principal')

@section('title', 'Modifier - ' . $dossier->nom)

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bg-white rounded shadow-sm p-5">
                <!-- En-tête -->
                <div class="text-center mb-5">
                    <div class="avatar avatar-xl rounded-circle d-flex align-items-center justify-content-center"
                        style="
                            --dossier-color: {{ $dossier->couleur }};
                            background-color: var(--dossier-color)20;
                            width: 80px;
                            height: 80px;
                        ">

                        <i class="fas {{ $dossier->icone_classe }} fa-3x"
                            style="color: var(--dossier-color);">
                        </i>

                    </div>
                    <h2 class="fw-bold">{{ $dossier->nom }}</h2>
                    <p class="text-muted">Modifier les informations du dossier</p>
                </div>

                <!-- Formulaire -->
                <form action="{{ route('back.dossiers.update', $dossier->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nom du dossier -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-folder me-2 text-primary"></i>
                            Nom du dossier <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control form-control-lg @error('nom') is-invalid @enderror"
                            name="nom"
                            value="{{ old('nom', $dossier->nom) }}"
                            required>
                        @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-align-left me-2 text-primary"></i>
                            Description
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                            name="description"
                            rows="3">{{ old('description', $dossier->description) }}</textarea>
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
                                <option value="{{ $societe->id }}"
                                    {{ old('societe_id', $dossier->societe_id) == $societe->id ? 'selected' : '' }}>
                                    {{ $societe->nom }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="fas fa-tasks me-2 text-primary"></i>
                                Activité associée
                            </label>
                            <select name="activite_id" class="form-select @error('activite_id') is-invalid @enderror">
                                <option value="">Aucune activité</option>
                                @foreach($activites as $activite)
                                <option value="{{ $activite->id }}"
                                    {{ old('activite_id', $dossier->activite_id) == $activite->id ? 'selected' : '' }}>
                                    {{ $activite->nom }}
                                </option>
                                @endforeach
                            </select>
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
                                {{ old('est_visible', $dossier->est_visible) ? 'checked' : '' }}>
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
                                value="{{ old('couleur', $dossier->couleur) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="fas fa-icons me-2 text-primary"></i>
                                Icône
                            </label>
                            <select name="icon" class="form-select">
                                <option value="fa-folder" {{ old('icon', $dossier->icon) == 'fa-folder' ? 'selected' : '' }}>📁 Dossier</option>
                                <option value="fa-folder-open" {{ old('icon', $dossier->icon) == 'fa-folder-open' ? 'selected' : '' }}>📂 Dossier ouvert</option>
                                <option value="fa-file-pdf" {{ old('icon', $dossier->icon) == 'fa-file-pdf' ? 'selected' : '' }}>📄 PDF</option>
                                <option value="fa-file-invoice" {{ old('icon', $dossier->icon) == 'fa-file-invoice' ? 'selected' : '' }}>📋 Factures</option>
                                <option value="fa-file-signature" {{ old('icon', $dossier->icon) == 'fa-file-signature' ? 'selected' : '' }}>✍️ Devis</option>
                            </select>
                        </div>
                    </div>

                    <!-- Informations supplémentaires -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                <strong>Informations :</strong><br>
                                Créé le {{ $dossier->created_at->format('d/m/Y à H:i') }}<br>
                                {{ $dossier->enfants_count }} sous-dossier(s) • {{ $dossier->fichiers_count }} fichier(s)
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ route('back.dossiers.show', $dossier->slug) }}"
                            class="btn btn-outline-secondary btn-lg px-5">
                            <i class="fas fa-times me-2"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-save me-2"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection