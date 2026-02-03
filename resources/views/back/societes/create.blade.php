@extends('back.layouts.principal')

@section('title', 'Nouvelle Société')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row">
        <div class="col-12">
            <!-- En-tête -->
            <div class="bg-white rounded shadow-sm p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold mb-1">
                            <i class="fas fa-building text-primary me-2"></i>
                            Nouvelle Société
                        </h4>
                        <p class="text-muted mb-0">Créez une nouvelle société dans le système</p>
                    </div>
                    <div>
                        <a href="{{ route('back.societes.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Retour
                        </a>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="card border-0 shadow-sm">
                <form action="{{ route('back.societes.store') }}" method="POST" enctype="multipart/form-data" id="societeForm">
                    @csrf
                    
                    <div class="card-body">
                        <div class="row">
                            <!-- Informations de base -->
                            <div class="col-lg-8">
                                <div class="card border-0 bg-light mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3 text-primary">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Informations de base
                                        </h6>
                                        
                                        <div class="row">
                                            <!-- Nom -->
                                            <div class="col-md-12 mb-3">
                                                <label for="nom" class="form-label required">Nom de la société</label>
                                                <input type="text" 
                                                       class="form-control @error('nom') is-invalid @enderror" 
                                                       id="nom" 
                                                       name="nom" 
                                                       value="{{ old('nom') }}" 
                                                       placeholder="Ex: Énergie Nova" 
                                                       required>
                                                @error('nom')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Le nom officiel de la société</div>
                                            </div>

                                            <!-- Adresse -->
                                            <div class="col-md-12 mb-3">
                                                <label for="adresse" class="form-label">Adresse</label>
                                                <input type="text" 
                                                       class="form-control @error('adresse') is-invalid @enderror" 
                                                       id="adresse" 
                                                       name="adresse" 
                                                       value="{{ old('adresse') }}" 
                                                       placeholder="Ex: 123 rue de la République">
                                                @error('adresse')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Code postal & Ville -->
                                            <div class="col-md-4 mb-3">
                                                <label for="code_postal" class="form-label">Code postal</label>
                                                <input type="text" 
                                                       class="form-control @error('code_postal') is-invalid @enderror" 
                                                       id="code_postal" 
                                                       name="code_postal" 
                                                       value="{{ old('code_postal') }}" 
                                                       placeholder="75001">
                                                @error('code_postal')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-8 mb-3">
                                                <label for="ville" class="form-label">Ville</label>
                                                <input type="text" 
                                                       class="form-control @error('ville') is-invalid @enderror" 
                                                       id="ville" 
                                                       name="ville" 
                                                       value="{{ old('ville') }}" 
                                                       placeholder="Ex: Paris">
                                                @error('ville')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Coordonnées -->
                                <div class="card border-0 bg-light mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3 text-primary">
                                            <i class="fas fa-address-card me-2"></i>
                                            Coordonnées
                                        </h6>
                                        
                                        <div class="row">
                                            <!-- Téléphone -->
                                            <div class="col-md-6 mb-3">
                                                <label for="telephone" class="form-label">Téléphone</label>
                                                <input type="tel" 
                                                       class="form-control @error('telephone') is-invalid @enderror" 
                                                       id="telephone" 
                                                       name="telephone" 
                                                       value="{{ old('telephone') }}" 
                                                       placeholder="Ex: 01 23 45 67 89">
                                                @error('telephone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" 
                                                       class="form-control @error('email') is-invalid @enderror" 
                                                       id="email" 
                                                       name="email" 
                                                       value="{{ old('email') }}" 
                                                       placeholder="Ex: contact@societe.fr">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Options & Apparence -->
                            <div class="col-lg-4">
                                <!-- Statut & Logo -->
                                <div class="card border-0 bg-light mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3 text-primary">
                                            <i class="fas fa-cog me-2"></i>
                                            Options
                                        </h6>

                                        <!-- Logo -->
                                        <div class="mb-4">
                                            <label for="logo" class="form-label">Logo</label>
                                            <div class="logo-upload-area border rounded p-4 text-center mb-3"
                                                 id="logoUploadArea">
                                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                                <p class="text-muted mb-2">Glissez-déposez ou cliquez pour uploader</p>
                                                <small class="text-muted">PNG, JPG (max 2Mo)</small>
                                            </div>
                                            <input type="file" 
                                                   class="form-control d-none @error('logo') is-invalid @enderror" 
                                                   id="logo" 
                                                   name="logo" 
                                                   accept="image/*">
                                            @error('logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="preview mt-3 d-none" id="logoPreview">
                                                <img src="" alt="Preview" class="img-thumbnail" style="max-height: 100px;">
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
                                                <label class="form-check-label fw-bold" for="est_active">
                                                    Société active
                                                </label>
                                            </div>
                                            <div class="form-text">Désactivez pour masquer cette société</div>
                                        </div>

                                        <!-- Code -->
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Code (optionnel)</label>
                                            <input type="text" 
                                                   class="form-control @error('code') is-invalid @enderror" 
                                                   id="code" 
                                                   name="code" 
                                                   value="{{ old('code') }}" 
                                                   placeholder="Généré automatiquement">
                                            @error('code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Identifiant unique de la société</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Apparence -->
                                <div class="card border-0 bg-light mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3 text-primary">
                                            <i class="fas fa-palette me-2"></i>
                                            Apparence
                                        </h6>

                                        <!-- Couleur -->
                                        <div class="mb-4">
                                            <label for="couleur" class="form-label">Couleur principale</label>
                                            <div class="color-picker">
                                                <input type="color" 
                                                       class="form-control form-control-color @error('couleur') is-invalid @enderror" 
                                                       id="couleur" 
                                                       name="couleur" 
                                                       value="{{ old('couleur', '#3B82F6') }}"
                                                       title="Choisir une couleur">
                                                @error('couleur')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-text">Couleur d'identification de la société</div>
                                        </div>

                                        <!-- Icône -->
                                        <div class="mb-3">
                                            <label for="icon" class="form-label">Icône</label>
                                            <select class="form-select @error('icon') is-invalid @enderror" 
                                                    id="icon" 
                                                    name="icon">
                                                @foreach($icones as $value => $label)
                                                    <option value="{{ $value }}" 
                                                            data-icon="{{ $value }}"
                                                            {{ old('icon', 'fa-building') == $value ? 'selected' : '' }}>
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
                                                    <i class="{{ old('icon', 'fa-building') }} fa-2x text-white"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations légales -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-0 bg-light mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3 text-primary">
                                            <i class="fas fa-balance-scale me-2"></i>
                                            Informations légales
                                        </h6>
                                        
                                        <div class="row">
                                            <!-- SIRET -->
                                            <div class="col-md-6 mb-3">
                                                <label for="siret" class="form-label">SIRET</label>
                                                <input type="text" 
                                                       class="form-control @error('siret') is-invalid @enderror" 
                                                       id="siret" 
                                                       name="siret" 
                                                       value="{{ old('siret') }}" 
                                                       placeholder="123 456 789 00012">
                                                @error('siret')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- TVA intracommunautaire -->
                                            <div class="col-md-6 mb-3">
                                                <label for="tva_intracommunautaire" class="form-label">TVA intracommunautaire</label>
                                                <input type="text" 
                                                       class="form-control @error('tva_intracommunautaire') is-invalid @enderror" 
                                                       id="tva_intracommunautaire" 
                                                       name="tva_intracommunautaire" 
                                                       value="{{ old('tva_intracommunautaire') }}" 
                                                       placeholder="Ex: FR12345678901">
                                                @error('tva_intracommunautaire')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activités -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-0 bg-light mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-3 text-primary">
                                            <i class="fas fa-tasks me-2"></i>
                                            Activités associées
                                        </h6>
                                        
                                        <div class="row">
                                            @foreach($activites as $activite)
                                                <div class="col-md-4 col-lg-3 mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               name="activites[]" 
                                                               value="{{ $activite->id }}" 
                                                               id="activite_{{ $activite->id }}"
                                                               {{ in_array($activite->id, old('activites', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label d-flex align-items-center" 
                                                               for="activite_{{ $activite->id }}">
                                                            <div class="me-2" 
                                                                 style="width: 20px; height: 20px; background-color: {{ $activite->couleur }}; border-radius: 4px;">
                                                            </div>
                                                            {{ $activite->nom }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        @if($activites->isEmpty())
                                            <div class="alert alert-info mb-0">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Aucune activité disponible. 
                                                <a href="{{ route('back.activites.create') }}" class="alert-link">
                                                    Créez-en une d'abord
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer du formulaire -->
                    <div class="card-footer bg-white border-0 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                    <i class="fas fa-times me-1"></i> Annuler
                                </button>
                            </div>
                            <div>
                                <button type="reset" class="btn btn-secondary me-2">
                                    <i class="fas fa-redo me-1"></i> Réinitialiser
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Créer la société
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Styles spécifiques au formulaire */
.required:after {
    content: " *";
    color: #dc3545;
}

.logo-upload-area {
    background-color: #f8f9fa;
    border: 2px dashed #dee2e6 !important;
    cursor: pointer;
    transition: all 0.3s ease;
}

.logo-upload-area:hover {
    border-color: #0d6efd !important;
    background-color: #e7f1ff;
}

.color-picker {
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-control-color {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    padding: 2px;
    border: 2px solid #dee2e6;
    cursor: pointer;
}

.icon-preview {
    transition: all 0.3s ease;
    min-width: 80px;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-check-input:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-check-label {
    cursor: pointer;
}

.form-check-label:hover {
    color: #0d6efd;
}

/* Animation pour la prévisualisation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.preview img {
    animation: fadeIn 0.3s ease;
}

/* Style pour les cartes */
.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

/* Validation */
.is-invalid {
    border-color: #dc3545 !important;
}

.is-valid {
    border-color: #198754 !important;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Gestion de l'upload du logo
    const logoInput = $('#logo');
    const logoUploadArea = $('#logoUploadArea');
    const logoPreview = $('#logoPreview');
    const previewImg = logoPreview.find('img');

    // Click sur la zone d'upload
    logoUploadArea.on('click', function() {
        logoInput.click();
    });

    // Drag & drop
    logoUploadArea.on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('border-primary');
    });

    logoUploadArea.on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('border-primary');
    });

    logoUploadArea.on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('border-primary');
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            handleLogoUpload(files[0]);
        }
    });

    // Changement via input file
    logoInput.on('change', function(e) {
        if (this.files && this.files[0]) {
            handleLogoUpload(this.files[0]);
        }
    });

    function handleLogoUpload(file) {
        // Vérification du type de fichier
        if (!file.type.match('image.*')) {
            toastr.error('Veuillez sélectionner une image');
            return;
        }

        // Vérification de la taille
        if (file.size > 2 * 1024 * 1024) {
            toastr.error('L\'image ne doit pas dépasser 2 Mo');
            return;
        }

        // Prévisualisation
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.attr('src', e.target.result);
            logoUploadArea.hide();
            logoPreview.removeClass('d-none').addClass('d-block');
        };
        reader.readAsDataURL(file);
    }

    // Suppression de la prévisualisation
    $(document).on('click', '#logoPreview', function() {
        logoInput.val('');
        logoPreview.addClass('d-none').removeClass('d-block');
        logoUploadArea.show();
    });

    // Mise à jour dynamique de la couleur de l'icône
    $('#couleur').on('input', function() {
        const color = $(this).val();
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

    // Validation du formulaire
    $('#societeForm').on('submit', function(e) {
        // Vérification des champs requis
        const nom = $('#nom').val().trim();
        if (nom === '') {
            e.preventDefault();
            toastr.error('Le nom de la société est obligatoire');
            $('#nom').focus();
            return;
        }

        // Validation de l'email si rempli
        const email = $('#email').val().trim();
        if (email !== '' && !isValidEmail(email)) {
            e.preventDefault();
            toastr.error('Veuillez entrer une adresse email valide');
            $('#email').focus();
            return;
        }

        // Validation du téléphone si rempli
        const telephone = $('#telephone').val().trim();
        if (telephone !== '' && !isValidPhone(telephone)) {
            e.preventDefault();
            toastr.error('Veuillez entrer un numéro de téléphone valide');
            $('#telephone').focus();
            return;
        }

        // Afficher un loader
        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Création en cours...');
    });

    // Fonctions de validation
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function isValidPhone(phone) {
        const re = /^[0-9\s\-\.\+\(\)]{10,20}$/;
        return re.test(phone);
    }

    // Afficher les tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Initialiser la prévisualisation de l'icône
    const initialColor = $('#couleur').val();
    $('.icon-preview').css('background-color', initialColor);
});
</script>
@endpush