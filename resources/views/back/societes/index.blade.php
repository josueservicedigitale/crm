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

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle switch
    $('.toggle-status').on('change', function() {
        const societeId = $(this).data('societe-id');
        const isChecked = $(this).is(':checked');
        const label = $(this).next('.form-check-label').find('span');
        
        // Animation visuelle
        $(this).prop('disabled', true);
        label.text('Chargement...').removeClass('text-success text-secondary');
        
        // Envoi AJAX
        $.ajax({
          url: "{{ route('back.societes.toggle', 'CODE_PLACEHOLDER') }}".replace('CODE_PLACEHOLDER', societeId),
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                _method: 'PATCH'
            },
            success: function(response) {
                if (response.success) {
                    // Mise à jour du label
                    if (response.est_active) {
                        label.text('Active').addClass('text-success').removeClass('text-secondary');
                    } else {
                        label.text('Inactive').addClass('text-secondary').removeClass('text-success');
                    }
                    
                    // Feedback utilisateur
                    toastr.success('Statut mis à jour');
                }
            },
            error: function(xhr) {
                // Annulation du changement
                const checkbox = $('.toggle-status[data-societe-id="' + societeId + '"]');
                checkbox.prop('checked', !isChecked);
                toastr.error('Erreur lors de la mise à jour');
            },
            complete: function() {
                $('.toggle-status').prop('disabled', false);
            }
        });
    });
    
    // Confirmation suppression
// Confirmation suppression
$(document).on('click', '.delete-societe', function(e) {
    e.preventDefault();
    
    const $button = $(this);
    const societeId = $button.data('id');
    const societeNom = $button.data('nom');
    const societeCode = $button.data('code'); // Si vous avez besoin du code
    
    Swal.fire({
        title: 'Confirmer la suppression',
        html: `
            <div class="text-center">
                <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                <p class="mb-1">Êtes-vous sûr de vouloir supprimer :</p>
                <p class="fw-bold text-danger">"${societeNom}"</p>
                <div class="alert alert-danger mt-3 py-2">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Attention !</strong> Cette action est irréversible.
                </div>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash me-2"></i>Supprimer',
        cancelButtonText: '<i class="fas fa-times me-2"></i>Annuler',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Afficher un loader
            Swal.fire({
                title: 'Suppression en cours...',
                text: 'Veuillez patienter',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Construire l'URL de suppression
            // Utilisez soit :id soit :code selon vos routes
            const deleteUrl = "{{ route('back.societes.destroy', ':id') }}".replace(':id', societeId);
            
            // Soumettre via AJAX pour mieux gérer les réponses
            $.ajax({
                url: deleteUrl,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: 'DELETE'
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Supprimé !',
                        text: response.message || 'Société supprimée avec succès',
                        icon: 'success',
                        confirmButtonColor: '#198754'
                    }).then(() => {
                        // Recharger la page
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Erreur !',
                        text: xhr.responseJSON?.message || 'Erreur lors de la suppression',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
});
</script>
@endpush