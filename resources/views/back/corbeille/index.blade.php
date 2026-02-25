@extends('back.layouts.principal')

@section('titre', 'Corbeille')

@section('content')
    <div class="container-fluid">
        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="fas fa-trash me-2"></i>Corbeille
            </h1>

            <div class="btn-group">
                <a href="{{ route('back.corbeille.restaurer-tous-formulaire') }}" class="btn btn-success">
                    <i class="fas fa-undo me-2"></i>Tout restaurer
                </a>
                <a href="{{ route('back.corbeille.vider-formulaire') }}" class="btn btn-danger">
                    <i class="fas fa-trash-alt me-2"></i>Vider la corbeille
                </a>
                <a href="{{ route('back.corbeille.telecharger-rapport') }}" class="btn btn-info">
                    <i class="fas fa-download me-2"></i>Télécharger rapport
                </a>
            </div>
        </div>

        <!-- Statistiques -->
<div class="row g-3 mb-4">

    @php
        $statsCards = [
            ['label' => 'Total', 'value' => $statistiques['total'], 'icon' => 'fa-layer-group', 'color' => 'primary'],
            ['label' => 'Utilisateurs', 'value' => $statistiques['utilisateurs'], 'icon' => 'fa-users', 'color' => 'info'],
            ['label' => 'Sociétés', 'value' => $statistiques['societes'], 'icon' => 'fa-building', 'color' => 'warning'],
            ['label' => 'Activités', 'value' => $statistiques['activites'], 'icon' => 'fa-tasks', 'color' => 'success'],
            ['label' => 'Documents', 'value' => $statistiques['documents'], 'icon' => 'fa-file', 'color' => 'secondary'],
            ['label' => 'Dossiers', 'value' => $statistiques['dossiers'], 'icon' => 'fa-folder', 'color' => 'dark'],
            ['label' => 'Fichiers', 'value' => $statistiques['fichiers'], 'icon' => 'fa-file-alt', 'color' => 'primary'],
        ];
    @endphp

    @foreach($statsCards as $card)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    
                    <div class="me-3">
                        <div class="rounded-circle bg-{{ $card['color'] }} bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width:45px;height:45px;">
                            <i class="fas {{ $card['icon'] }} text-{{ $card['color'] }}"></i>
                        </div>
                    </div>

                    <div>
                        <div class="text-muted small">{{ $card['label'] }}</div>
                        <div class="fs-4 fw-bold">{{ $card['value'] }}</div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach

</div>
        <!-- Filtres et recherche -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="recherche" class="form-control" placeholder="Rechercher..."
                            value="{{ request('recherche') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="type" class="form-select">
                            <option value="">Tous les types</option>
                            @foreach($typesDisponibles as $classe => $nom)
                                <option value="{{ $classe }}" {{ request('type') == $classe ? 'selected' : '' }}>
                                    {{ $nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}"
                            placeholder="Date début">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}"
                            placeholder="Date fin">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Filtrer
                        </button>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('back.corbeille.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des éléments -->
        <div class="card">
            <div class="card-body">
                <form id="form-actions-groupées" action="{{ route('back.corbeille.actions-groupées') }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between mb-3">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary" onclick="selectionnerTous()">
                                <i class="fas fa-check-square me-2"></i>Tout sélectionner
                            </button>
                            <button type="button" class="btn btn-outline-primary" onclick="deselectionnerTous()">
                                <i class="fas fa-square me-2"></i>Tout désélectionner
                            </button>
                        </div>
                        <div class="btn-group">
                            <button type="submit" name="action" value="restaurer" class="btn btn-success"
                                onclick="return confirm('Restaurer les éléments sélectionnés ?')">
                                <i class="fas fa-undo me-2"></i>Restaurer sélection
                            </button>
                            <button type="submit" name="action" value="supprimer" class="btn btn-danger"
                                onclick="return confirm('Supprimer définitivement les éléments sélectionnés ?')">
                                <i class="fas fa-trash me-2"></i>Supprimer sélection
                            </button>
                        </div>
                    </div>

                    @if($elementsCorbeille->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="select-all">
                                        </th>
                                        <th>Type</th>
                                        <th>Élément</th>
                                        <th>Supprimé par</th>
                                        <th>Date suppression</th>
                                        <th>Expiration</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($elementsCorbeille as $element)
                                        <tr class="{{ $element->a_expire ? 'table-danger' : '' }}">
                                            <td>
                                                <input type="checkbox" name="ids[]" value="{{ $element->id }}" class="select-item">
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $element->nom_type }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $d = $element->donnees ?? [];
                                                    $label = $d['nom']
                                                        ?? $d['name']
                                                        ?? $d['titre']
                                                        ?? $d['email']
                                                        ?? $d['nom_original']   // ✅ utile pour Fichier
                                                        ?? $d['slug']           // ✅ utile pour Dossier
                                                        ?? null;
                                                @endphp

                                                {{ $label ? $label : "ID: {$element->element_id}" }}
                                            </td>

                                            <td>
                                                {{ $element->supprimePar->name ?? 'Système' }}
                                            </td>
                                            <td>
                                                {{ $element->supprime_le->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                @if($element->expire_le)
                                                    @if($element->a_expire)
                                                        <span class="badge bg-danger">Expiré</span>
                                                    @else
                                                        <span class="badge bg-warning">Dans {{ $element->jours_restants }} jours</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">Illimité</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('back.corbeille.afficher', $element->id) }}"
                                                        class="btn btn-info" title="Afficher">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button
                                                        onclick="restaurerElement('{{ route('back.corbeille.restaurer', $element->id) }}')"
                                                        class="btn btn-success" title="Restaurer">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                    <button
                                                        onclick="supprimerElement('{{ route('back.corbeille.supprimer-definitivement', $element->id) }}')"
                                                        class="btn btn-danger" title="Supprimer définitivement">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $elementsCorbeille->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-trash fa-4x text-muted mb-3"></i>
                            <h4>Corbeille vide</h4>
                            <p class="text-muted">Aucun élément dans la corbeille</p>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Sélection/désélection de tous les éléments
        function selectionnerTous() {
            document.querySelectorAll('.select-item').forEach(checkbox => {
                checkbox.checked = true;
            });
            document.getElementById('select-all').checked = true;
        }

        function deselectionnerTous() {
            document.querySelectorAll('.select-item').forEach(checkbox => {
                checkbox.checked = false;
            });
            document.getElementById('select-all').checked = false;
        }

        // Gestion de la case "Tout sélectionner"
        document.getElementById('select-all').addEventListener('change', function () {
            document.querySelectorAll('.select-item').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Restaurer un élément
        function restaurerElement(url) {
            if (confirm('Voulez-vous restaurer cet élément ?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Supprimer définitivement un élément
        function supprimerElement(url) {
            if (confirm('Supprimer définitivement cet élément ? Cette action est irréversible !')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection