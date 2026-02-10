@extends('back.layouts.principal')

@section('title', 'Gestion des Sociétés')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <!-- En-tête avec bouton d'ajout et statistiques -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-0 text-white">
                    <i class="fas fa-building me-2 text-primary"></i>🏢 Gestion des Sociétés
                </h4>
                <small class="text-muted">Gérez vos sociétés partenaires</small>
            </div>
            <a href="{{ route('back.societes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouvelle Société
            </a>
        </div>
        
        <!-- Statistiques -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6">
                <div class="bg-dark rounded p-3">
                    <h6 class="text-white mb-2">Total Sociétés</h6>
                    <h3 class="text-primary mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="bg-dark rounded p-3">
                    <h6 class="text-white mb-2">Actives</h6>
                    <h3 class="text-success mb-0">{{ $stats['actives'] }}</h3>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="bg-dark rounded p-3">
                    <h6 class="text-white mb-2">Inactives</h6>
                    <h3 class="text-secondary mb-0">{{ $stats['inactives'] }}</h3>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="bg-dark rounded p-3">
                    <h6 class="text-white mb-2">Documents</h6>
                    <h3 class="text-info mb-0">{{ $stats['documents_total'] }}</h3>
                </div>
            </div>
        </div>
        
        <!-- Tableau des sociétés -->
        <div class="table-responsive">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Société</th>
                        <th scope="col">Code</th>
                        <th scope="col">Ville</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Documents</th>
                        <th scope="col">Activités</th>
                        <th scope="col">Création</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($societes as $societe) {{-- CORRECTION: $societes au lieu de $activites --}}
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-2 me-2" 
                                     style="background-color: {{ $societe->couleur }}; width: 40px; height: 40px;">
                                    <i class="{{ $societe->icon }} text-white"></i>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $societe->nom }}</strong><br>
                            <small class="text-muted">
                                @if($societe->email)
                                    <i class="fas fa-envelope me-1"></i>{{ $societe->email }}
                                @endif
                            </small>
                        </td>
                        <td>
                            <code class="text-info">{{ $societe->code }}</code>
                        </td>
                        <td>
                            @if($societe->ville)
                                <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                                {{ $societe->ville }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <!-- Bouton toggle -->
                            <div class="form-check form-switch">
                                <input class="form-check-input toggle-status" 
                                       type="checkbox" 
                                       role="switch"
                                       data-societe-id="{{ $societe->id }}"
                                       id="toggle{{ $societe->id }}"
                                       {{ $societe->est_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="toggle{{ $societe->id }}">
                                    <span class="{{ $societe->est_active ? 'text-success' : 'text-secondary' }}">
                                        {{ $societe->est_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </label>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info rounded-pill">
                                {{ $societe->documents_count }}
                            </span>
                        </td>
                        <td>
                            @if($societe->activites->count() > 0)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($societe->activites->take(2) as $activite)
                                        <span class="badge" style="background-color: {{ $activite->couleur }}">
                                            {{ $activite->nom }}
                                        </span>
                                    @endforeach
                                    @if($societe->activites->count() > 2)
                                        <span class="badge bg-secondary">
                                            +{{ $societe->activites->count() - 2 }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            {{ $societe->created_at->format('d/m/Y') }}
                        </td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('back.societes.show', $societe->code) }}" 
                                   class="btn btn-sm btn-outline-info" 
                                   title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('back.societes.edit', $societe->code) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger delete-societe"
                                        data-id="{{ $societe->id }}"
                                        data-nom="{{ $societe->nom }}"
                                        title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-building fa-2x mb-3"></i>
                            <p>Aucune société trouvée</p>
                            <a href="{{ route('back.societes.create') }}" class="btn btn-sm btn-primary">
                                Créer une première société
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination si nécessaire -->
        @if($societes->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $societes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    console.log('Script sociétés chargé');
    
    // Toggle switch
    $('.toggle-status').on('change', function() {
        const checkbox = $(this);
        const societeId = checkbox.data('societe-id');
        const isChecked = checkbox.is(':checked');
        
        console.log('Toggle société ID:', societeId, '->', isChecked ? 'actif' : 'inactif');
        
        // Désactiver pendant la requête
        checkbox.prop('disabled', true);
        
        // Envoi AJAX SIMPLE
        $.ajax({
            url: "/back/societes/" + societeId + "/toggle",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log('Réponse:', response);
                
                if (response.success) {
                    // Rafraîchir la page immédiatement
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                } else {
                    // Revenir à l'état précédent
                    checkbox.prop('checked', !isChecked);
                    alert('Erreur: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX:', error);
                console.log('Status:', xhr.status);
                
                // Revenir à l'état précédent
                checkbox.prop('checked', !isChecked);
                alert('Erreur de connexion au serveur');
            },
            complete: function() {
                checkbox.prop('disabled', false);
            }
        });
    });
    });

    
</script>
@endpush