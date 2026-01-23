<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">

        <!-- Brand -->
        <a href="{{ route('dashboard') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
        </a>

        <!-- User Info -->
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                <span>Admin</span>
            </div>
        </div>

        @php
            $activites = [
                'desembouage' => 'Désembouage',
                'reequilibrage' => 'Rééquilibrage'
            ];

            $societes = [
                'nova' => 'Énergie Nova',
                'house' => 'MyHouse Solutions'
            ];

            $documentTypes = [
                'devis' => ['icon' => 'fa-file-invoice', 'label' => 'Devis'],
                'facture' => ['icon' => 'fa-file-invoice-dollar', 'label' => 'Factures'],
                'attestation' => ['icon' => 'fa-certificate', 'label' => 'Attestations'],
                'rapport' => ['icon' => 'fa-chart-line', 'label' => 'Rapports'],
                'cahier-des-charges' => ['icon' => 'fa-book', 'label' => 'Cahiers des charges']
            ];

            // Valeurs dynamiques pour l'activité et la société en cours
            $currentActivity = request()->route('activity') ?? array_key_first($activites);
            $currentSociety  = request()->route('society') ?? array_key_first($societes);
        @endphp

        <div class="navbar-nav w-100">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            <!-- ACTIVITÉS -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-tasks me-2"></i>ACTIVITÉS
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    @foreach($activites as $key => $label)
                        <a href="{{ route('back.activite.show', ['activite' => $key]) }}"
                           class="dropdown-item {{ $currentActivity === $key ? 'active' : '' }}">
                            <i class="fa fa-gear me-2"></i>{{ $label }}
                        </a>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('back.activite.create') }}" class="dropdown-item">
                        <i class="fa fa-plus me-2"></i>Ajouter une activité
                    </a>
                </div>
            </div>

            <!-- SOCIÉTÉS -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-building me-2"></i>SOCIÉTÉS
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    @foreach($societes as $key => $label)
                        <a href="{{ route('back.societe.show', ['societe' => $key]) }}"
                           class="dropdown-item {{ $currentSociety === $key ? 'active' : '' }}">
                            <i class="fa fa-building me-2"></i>{{ $label }}
                        </a>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('back.societe.create') }}" class="dropdown-item">
                        <i class="fa fa-plus me-2"></i>Ajouter une société
                    </a>
                </div>
            </div>

            <!-- ESPACES DE TRAVAIL -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-project-diagram me-2"></i>ESPACES DE TRAVAIL
                </a>
                <div class="dropdown-menu bg-transparent border-0">
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
                    <a href="{{ route('back.document.list', ['activity' => $currentActivity, 'society' => $currentSociety, 'type' => 'all']) }}" class="dropdown-item">
                        <i class="fa fa-folder-open me-2"></i>Tous les documents
                    </a>
                    <a href="{{ route('back.document.create', ['activity' => $currentActivity, 'society' => $currentSociety, 'type' => 'quick']) }}" class="dropdown-item">
                        <i class="fa fa-plus-circle me-2"></i>Création rapide
                    </a>
                    <div class="dropdown-divider"></div>
                    @foreach($documentTypes as $typeKey => $type)
                        <a href="{{ route('back.document.list', ['activity' => $currentActivity, 'society' => $currentSociety, 'type' => $typeKey]) }}" class="dropdown-item">
                            <i class="fa {{ $type['icon'] }} me-2"></i>{{ $type['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Widgets / Forms / Tables / Charts -->
            <a href="#" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>
            <a href="#" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>
            <a href="#" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
            <a href="#" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>

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
