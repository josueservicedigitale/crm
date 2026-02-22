<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">

        <!-- Brand -->
        <a href="{{ route('home.dashboard') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
        </a>

        <!-- User Info -->
        <div class="d-flex align-items-center ms-4 mb-4">
            <a href="{{ route('profile.edit') }}"
                class="text-decoration-none text-dark d-flex align-items-center w-100">
                <div class="position-relative">
                    <img class="rounded-circle"
                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('img/user.jpg') }}"
                        alt="Photo de profil" style="width: 40px; height: 40px; object-fit: cover;">
                </div>
                <div class="ms-3">
                    <h6 class="mb-0">
                        @auth
                        {{ Auth::user()->name ?? 'Utilisateur' }}
                        @else
                        Non connecté
                        @endauth
                    </h6>
                    <span class="text-muted">
                        @auth
                        {{ Auth::user()->estAdministrateur() ? 'Administrateur' : 'Utilisateur' }}
                        @else
                        Invité
                        @endauth
                    </span>
                </div>
            </a>
        </div>

        @php
        use App\Models\Activite;
        use App\Models\Societe;
        use App\Models\User;
        use App\Models\Document;

        // Récupère uniquement les activités actives
        $activites = Activite::active()->orderBy('nom')->pluck('nom', 'code')->toArray();

        // Récupère uniquement les SOCIÉTÉS ACTIVES
        $societesActives = Societe::active()
        ->orderBy('nom')
        ->get()
        ->mapWithKeys(function ($societe) {
        return [$societe->code => $societe->nom_formate];
        })
        ->toArray();

        // Utilisez les sociétés actives de la base de données
        $societes = $societesActives;

        $documentTypes = [
        'devis' => ['icon' => 'fa-file-invoice', 'label' => 'Devis'],
        'facture' => ['icon' => 'fa-file-invoice-dollar', 'label' => 'Factures'],
        'attestation_realisation' => ['icon' => 'fa-certificate', 'label' => 'Attestations réalisation'],
        'attestation_signataire' => ['icon' => 'fa-certificate', 'label' => 'Attestations signataire'],
        'rapport' => ['icon' => 'fa-chart-line', 'label' => 'Rapports'],
        'cahier_des_charges' => ['icon' => 'fa-book', 'label' => 'Cahiers des charges']
        ];

        $currentActivity = request()->route('activity') ?? array_key_first($activites);
        $currentSociety = request()->route('society') ?? array_key_first($societes);
        @endphp

        <div class="navbar-nav w-100">
            <!-- Dashboard -->
            <a href="{{ route('home.dashboard') }}"
                class="nav-item nav-link {{ request()->routeIs('home.dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            <!-- ACTIVITÉS -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-tasks me-2"></i>ACTIVITÉS
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    @foreach($activites as $key => $label)
                    <a href="{{ route('back.activites.show', $key) }}"
                        class="dropdown-item {{ $currentActivity === $key ? 'active' : '' }}">
                        <i class="fa fa-gear me-2"></i>{{ $label }}
                    </a>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('back.activites.create') }}" class="dropdown-item">
                        <i class="fa fa-plus me-2"></i>Ajouter une activité
                    </a>
                    <a href="{{ route('back.activites.index') }}" class="dropdown-item">
                        <i class="fas fa-list me-2"></i>Toutes les activités
                    </a>
                </div>
            </div>

            <!-- SOCIÉTÉS -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-building me-2"></i>SOCIÉTÉS
                    @if(empty($societes))
                    <span class="badge bg-danger ms-2">Aucune</span>
                    @endif
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    @if(!empty($societes))
                    @foreach($societes as $key => $label)
                    <a href="{{ route('back.societes.show', $key) }}"
                        class="dropdown-item {{ $currentSociety === $key ? 'active' : '' }}">
                        <i class="fa fa-building me-2"></i>{{ $label }}
                    </a>
                    @endforeach
                    @else
                    <div class="dropdown-item text-muted">
                        <i class="fa fa-exclamation-triangle me-2"></i>
                        Aucune société active
                    </div>
                    @endif

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('back.societes.create') }}" class="dropdown-item">
                        <i class="fa fa-plus me-2"></i>Ajouter une société
                    </a>
                    <a href="{{ route('back.societes.index') }}" class="dropdown-item">
                        <i class="fas fa-list me-2"></i>Toutes les sociétés
                    </a>
                </div>
            </div>

            <!-- UTILISATEURS - Admin seulement -->
            @if(auth()->check() && auth()->user()->estAdministrateur())
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-users me-2"></i>UTILISATEURS
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('back.users.index') }}"
                        class="dropdown-item {{ request()->routeIs('back.users.*') && !request()->routeIs('back.users.create') ? 'active' : '' }}">
                        <i class="fa fa-list me-2"></i>Tous les utilisateurs
                    </a>
                    <a href="{{ route('back.users.create') }}"
                        class="dropdown-item {{ request()->routeIs('back.users.create') ? 'active' : '' }}">
                        <i class="fa fa-plus me-2"></i>Ajouter un utilisateur
                    </a>
                    <div class="dropdown-divider"></div>
                    <span class="dropdown-item-text text-muted">
                        <small>
                            <i class="fa fa-shield-alt me-1"></i>
                            Admins: {{ User::where('role', 'admin')->count() }} |
                            Actifs: {{ User::where('est_actif', true)->count() }}
                        </small>
                    </span>
                </div>
            </div>
            @endif

            <!-- ESPACES DE TRAVAIL -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle d-flex justify-content-between align-items-center"
                    data-bs-toggle="dropdown">
                    <span><i class="fa fa-project-diagram me-2"></i>ESPACES TRAVAIL</span>
                    @if(empty($societes))
                    <small class="text-warning">(sociétés manquantes)</small>
                    @endif
                </a>
                <div class="dropdown-menu bg-transparent border-0 w-100">
                    @if(!empty($activites) && !empty($societes))
                    @foreach($activites as $actKey => $actLabel)
                    <h6 class="dropdown-header">
                        <i class="fa fa-tasks me-2"></i>{{ $actLabel }}
                    </h6>
                    @foreach($societes as $socKey => $socLabel)
                    <a href="{{ route('back.dashboard', ['activity' => $actKey, 'society' => $socKey]) }}"
                        class="dropdown-item ps-4 {{ $currentActivity === $actKey && $currentSociety === $socKey ? 'active' : '' }}">
                        <i class="fa fa-building me-2"></i>{{ $socLabel }}
                    </a>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    @endforeach
                    @else
                    <div class="dropdown-item text-muted">
                        @if(empty($activites))
                        <i class="fa fa-exclamation-circle me-2"></i>
                        Aucune activité active
                        @elseif(empty($societes))
                        <i class="fa fa-exclamation-circle me-2"></i>
                        Aucune société active
                        @endif
                    </div>
                    @endif
                    <a href="{{ route('back.all-dashboards') }}" class="dropdown-item">
                        <i class="fa fa-eye me-2"></i>Voir tous les espaces
                    </a>
                </div>
            </div>

            <!-- DOCUMENTS -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="far fa-file-alt me-2"></i>DOCUMENTS
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('back.document.list', ['activity' => $currentActivity, 'society' => $currentSociety, 'type' => 'all']) }}"
                        class="dropdown-item">
                        <i class="fa fa-folder-open me-2"></i>Tous les documents
                    </a>
                    <a href="{{ route('back.document.create', ['activity' => $currentActivity, 'society' => $currentSociety, 'type' => 'quick']) }}"
                        class="dropdown-item">
                        <i class="fa fa-plus-circle me-2"></i>Création rapide
                    </a>
                    <div class="dropdown-divider"></div>
                    @foreach($documentTypes as $typeKey => $type)
                    <a href="{{ route('back.document.list', ['activity' => $currentActivity, 'society' => $currentSociety, 'type' => $typeKey]) }}"
                        class="dropdown-item">
                        <i class="fa {{ $type['icon'] }} me-2"></i>{{ $type['label'] }}
                    </a>
                    @endforeach
                </div>
            </div>


            <!-- DOSSIERS - NOUVEAU -->
            <div class="nav-item">
                <a href="{{ route('back.dossiers.index') }}"
                    class="nav-link {{ request()->routeIs('back.dossiers.*') ? 'active' : '' }}">
                    <i class="fas fa-folder me-2"></i>
                    <span>Mes dossiers</span>
                    @php
                    $nbDossiers = \App\Models\Dossier::pourUtilisateur(auth()->id())->count();
                    @endphp
                    @if($nbDossiers > 0)
                    <span class="badge bg-info ms-auto">{{ $nbDossiers }}</span>
                    @endif
                </a>
            </div>

            <!-- Sous-menu dossiers (optionnel) -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-folder-tree me-2"></i>
                    <span>Gestion dossiers</span>
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('back.dossiers.index') }}?visibilite=public" class="dropdown-item">
                        <i class="fas fa-globe me-2 text-success"></i>Dossiers publics
                    </a>
                    <a href="{{ route('back.dossiers.index') }}?visibilite=prive" class="dropdown-item">
                        <i class="fas fa-lock me-2 text-warning"></i>Dossiers privés
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('back.dossiers.create') }}" class="dropdown-item">
                        <i class="fas fa-plus me-2 text-primary"></i>Nouveau dossier
                    </a>
                </div>
            </div>

            <!-- CORBEILLE -->
            @php
            $corbeilleCount = Document::onlyTrashed()->count() +
            Activite::onlyTrashed()->count() +
            Societe::onlyTrashed()->count();
            @endphp
            <a href="{{ route('back.corbeille.index') }}" class="nav-item nav-link {{ request()->routeIs('back.corbeille.*') ? 'active' : '' }}">
                <i class="fa fa-trash me-2"></i>Corbeille
                @if($corbeilleCount > 0)
                <span class="badge bg-danger float-end badge-pulse">
                    {{ $corbeilleCount }}
                </span>
                @endif
            </a>

            <!-- PARAMÈTRES -->
            <a href="{{ route('back.parametres.index') }}" class="nav-item nav-link {{ request()->routeIs('back.parametres.*') ? 'active' : '' }}">
                <i class="fa fa-cog me-2"></i>Paramètres
            </a>

            <!-- Widgets / Forms / Tables / Charts -->
            <!-- <a href="#" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>
            <a href="#" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>
            <a href="#" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
            <a href="#" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a> -->

            <!-- Pages -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="far fa-file-alt me-2"></i>Pages
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="#" class="dropdown-item">Sign In</a>
                    <a href="#" class="dropdown-item">Sign Up</a>
                    <a href="#" class="dropdown-item">404 Error</a>
                    <a href="#" class="dropdown-item">Blank Page</a>
                </div>
            </div>

        </div>
    </nav>
</div>
<!-- Sidebar End -->