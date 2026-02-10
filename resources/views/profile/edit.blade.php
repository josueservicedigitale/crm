
@extends('back.layouts.principal')

@section('titre', 'Mon Profil')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <i class="fas fa-user-circle me-2"></i>Mon Profil
                </h1>
                <div>
                    <span class="badge bg-info">Membre depuis : {{ Auth::user()->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
            <p class="text-muted">Gérez vos informations personnelles, votre mot de passe et votre compte.</p>
        </div>
    </div>

    <div class="row">
        <!-- Colonne de gauche : Informations utilisateur -->
        <div class="col-lg-4 col-md-5">
            <!-- Carte profil -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <!-- Avatar -->
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3b82f6&color=fff' }}" 
                             alt="Avatar" 
                             class="rounded-circle border border-4 border-primary"
                             style="width: 150px; height: 150px; object-fit: cover;">
                        <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top"
                                title="Changer la photo"
                                onclick="document.getElementById('avatar-input').click()">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    
                    <!-- Informations utilisateur -->
                    <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                    <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                    
                    @if(Auth::user()->telephone)
                    <p class="mb-3">
                        <i class="fas fa-phone me-1"></i> {{ Auth::user()->telephone }}
                    </p>
                    @endif
                    
                    <!-- Rôle -->
                    <span class="badge bg-{{ Auth::user()->estAdministrateur() ? 'danger' : 'success' }} mb-3">
                        {{ Auth::user()->estAdministrateur() ? 'Administrateur' : 'Utilisateur' }}
                    </span>
                    
                    <!-- Dernière connexion -->
                    <div class="alert alert-light mt-3">
                        <small>
                            <i class="fas fa-clock me-1"></i>
                            Dernière connexion : 
                            {{ Auth::user()->derniere_connexion ? Auth::user()->derniere_connexion->format('d/m/Y H:i') : 'Jamais' }}
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Statistiques -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Mes Statistiques</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border rounded p-2">
                                <h5 class="mb-0 text-primary">{{ $statistiques['societes'] }}</h5>
                                <small class="text-muted">Sociétés</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2">
                                <h5 class="mb-0 text-success">{{ $statistiques['activites'] }}</h5>
                                <small class="text-muted">Activités</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2">
                                <h5 class="mb-0 text-warning">{{ $statistiques['documents'] }}</h5>
                                <small class="text-muted">Documents</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne de droite : Formulaires -->
        <div class="col-lg-8 col-md-7">
            <!-- Onglets -->
            <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                        <i class="fas fa-user-edit me-2"></i>Informations
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                        <i class="fas fa-key me-2"></i>Mot de passe
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="danger-tab" data-bs-toggle="tab" data-bs-target="#danger" type="button" role="tab">
                        <i class="fas fa-exclamation-triangle me-2"></i>Zone de danger
                    </button>
                </li>
            </ul>

            <!-- Contenu des onglets -->
            <div class="tab-content" id="profileTabContent">
                <!-- Onglet 1 : Informations personnelles -->
                <div class="tab-pane fade show active" id="info" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Informations personnelles</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                
                                <!-- Champ caché pour l'avatar -->
                                <input type="file" id="avatar-input" name="avatar" class="d-none" accept="image/*" onchange="this.form.submit()">
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">
                                            Nom complet
                                            <i class="fas fa-info-circle ms-1" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-placement="top"
                                               title="Votre nom complet tel qu'il apparaîtra dans le système"></i>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', Auth::user()->name) }}"
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">
                                            Adresse email
                                            <i class="fas fa-info-circle ms-1" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-placement="top"
                                               title="Utilisée pour la connexion et les notifications"></i>
                                        </label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', Auth::user()->email) }}"
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="telephone" class="form-label">
                                            Téléphone
                                            <i class="fas fa-info-circle ms-1" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-placement="top"
                                               title="Numéro facultatif pour les contacts"></i>
                                        </label>
                                        <input type="tel" 
                                               class="form-control @error('telephone') is-invalid @enderror" 
                                               id="telephone" 
                                               name="telephone" 
                                               value="{{ old('telephone', Auth::user()->telephone) }}"
                                               placeholder="06 12 34 56 78">
                                        @error('telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Les modifications seront appliquées immédiatement
                                        </small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Onglet 2 : Mot de passe -->
                <div class="tab-pane fade" id="password" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i>Sécurité du compte</h5>
                        </div>
                        <div class="card-body">
                            @if(session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ route('profile.password.update') }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">
                                        Mot de passe actuel
                                        <i class="fas fa-info-circle ms-1" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top"
                                           title="Entrez votre mot de passe actuel pour confirmer votre identité"></i>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" 
                                               name="current_password"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        Nouveau mot de passe
                                        <i class="fas fa-info-circle ms-1" 
                                           data-bs-toggle="tooltip" 
                                           data-bs-placement="top"
                                           title="Minimum 8 caractères avec majuscules, minuscules et chiffres"></i>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="progress mt-2" style="height: 5px;">
                                        <div class="progress-bar" id="password-strength-bar" role="progressbar"></div>
                                    </div>
                                    <small class="text-muted" id="password-strength-text"></small>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">
                                        Confirmer le nouveau mot de passe
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control" 
                                               id="password_confirmation" 
                                               name="password_confirmation"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-lightbulb me-2"></i>Conseils de sécurité</h6>
                                    <ul class="mb-0">
                                        <li>Utilisez un mot de passe unique pour ce compte</li>
                                        <li>Évitez les mots courants ou les informations personnelles</li>
                                        <li>Changez votre mot de passe régulièrement</li>
                                    </ul>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-key me-2"></i>Changer le mot de passe
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Onglet 3 : Zone de danger -->
                <div class="tab-pane fade" id="danger" role="tabpanel">
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Zone de danger</h5>
                        </div>
                        <div class="card-body">
                            <!-- Suppression de compte -->
                            <div class="border rounded p-4 mb-4">
                                <h6 class="text-danger mb-3">
                                    <i class="fas fa-user-slash me-2"></i>Supprimer mon compte
                                </h6>
                                <p class="text-muted mb-3">
                                    Une fois votre compte supprimé, toutes vos ressources et données seront effacées définitivement. 
                                    Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.
                                </p>
                                
                                <button class="btn btn-outline-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteAccountModal">
                                    <i class="fas fa-trash me-2"></i>Supprimer mon compte
                                </button>
                            </div>
                            
                            <!-- Session active -->
                            <div class="border rounded p-4">
                                <h6 class="mb-3">
                                    <i class="fas fa-desktop me-2"></i>Sessions actives
                                </h6>
                                <p class="text-muted mb-3">
                                    Si nécessaire, vous pouvez déconnecter toutes vos autres sessions sur tous vos appareils.
                                </p>
                                
                                <button class="btn btn-outline-warning" 
                                        onclick="event.preventDefault(); document.getElementById('logout-other-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion sur tous les appareils
                                </button>
                                
                                <form id="logout-other-form" action="{{ route('logout.other') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression de compte -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Supprimer le compte
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h6 class="alert-heading">Attention ! Action irréversible</h6>
                    <p class="mb-0">
                        Êtes-vous sûr de vouloir supprimer votre compte ? Cette action ne peut pas être annulée.
                        <br><br>
                        <strong>Conséquences :</strong>
                    </p>
                    <ul class="mt-2 mb-0">
                        <li>Toutes vos données seront supprimées</li>
                        <li>Vos sociétés et activités seront perdues</li>
                        <li>Vous ne pourrez plus vous connecter</li>
                    </ul>
                </div>
                
                <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">
                            Entrez votre mot de passe pour confirmer
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="delete_password" 
                               name="password"
                               required>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                        <label class="form-check-label" for="confirmDelete">
                            Je comprends que cette action est irréversible
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Supprimer définitivement
                </button>
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
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialiser les onglets
    var triggerTabList = [].slice.call(document.querySelectorAll('#profileTab button'));
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl);
        
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            tabTrigger.show();
        });
    });
    
    // Vérification de la force du mot de passe
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('password-strength-bar');
    const strengthText = document.getElementById('password-strength-text');
    
    if (passwordInput && strengthBar && strengthText) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            strengthBar.style.width = strength.percentage + '%';
            strengthBar.className = 'progress-bar ' + strength.class;
            strengthText.textContent = strength.text;
            strengthText.className = 'text-' + strength.textClass;
        });
    }
});

// Afficher/masquer le mot de passe
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

// Vérifier la force du mot de passe
function checkPasswordStrength(password) {
    let score = 0;
    
    if (password.length >= 8) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;
    
    const strengthMap = [
        { percentage: 20, class: 'bg-danger', text: 'Très faible', textClass: 'danger' },
        { percentage: 40, class: 'bg-warning', text: 'Faible', textClass: 'warning' },
        { percentage: 60, class: 'bg-info', text: 'Moyen', textClass: 'info' },
        { percentage: 80, class: 'bg-primary', text: 'Fort', textClass: 'primary' },
        { percentage: 100, class: 'bg-success', text: 'Très fort', textClass: 'success' }
    ];
    
    return strengthMap[Math.min(score, strengthMap.length - 1)];
}

// Validation avant suppression
document.getElementById('deleteAccountForm')?.addEventListener('submit', function(e) {
    if (!document.getElementById('confirmDelete').checked) {
        e.preventDefault();
        alert('Veuillez confirmer que vous comprenez les conséquences.');
        return false;
    }
});
</script>
@endsection

<style>
.progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    transition: width 0.3s ease;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 3px solid #0d6efd;
    background: transparent;
}

.card {
    border: 1px solid #e3e6f0;
    border-radius: 0.5rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-header {
    border-bottom: 1px solid #e3e6f0;
    background-color: #f8f9fc;
}

.border-danger {
    border-color: #e74a3b !important;
}

.input-group-text {
    cursor: pointer;
}

.rounded-circle {
    transition: transform 0.2s;
}

.rounded-circle:hover {
    transform: scale(1.1);
}
</style>