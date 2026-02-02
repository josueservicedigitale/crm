@extends('back.layouts.principal')

@section('title', 'Gestion des Activités')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <!-- En-tête avec bouton d'ajout et statistiques -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-0">📋 Gestion des Activités</h4>
                <small class="text-muted">Gérez les différents types d'interventions</small>
            </div>
            <a href="{{ route('back.activites.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouvelle Activité
            </a>
        </div>
        
        <!-- Statistiques -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6">
                <div class="bg-dark rounded p-3">
                    <h6 class="text-white mb-2">Total Activités</h6>
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
        
        <!-- Tableau des activités -->
        <div class="table-responsive">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Activité</th>
                        <th scope="col">Code</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Documents</th>
                        <th scope="col">Créée le</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activites as $activite)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-2 me-2" 
                                     style="background-color: {{ $activite->couleur }}; width: 40px; height: 40px;">
                                    <i class="{{ $activite->icon }} text-white"></i>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong>{{ $activite->nom }}</strong><br>
                            <small class="text-muted">{{ $activite->description ?? 'Sans description' }}</small>
                        </td>
                        <td>
                            <code class="text-info">{{ $activite->code }}</code>
                        </td>
                        <td>
                            <!-- Bouton toggle comme Bluetooth -->
                            <div class="form-check form-switch">
                                <input class="form-check-input toggle-status" 
                                       type="checkbox" 
                                       role="switch"
                                       data-activite-id="{{ $activite->id }}"
                                       id="toggle{{ $activite->id }}"
                                       {{ $activite->est_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="toggle{{ $activite->id }}">
                                    <span class="{{ $activite->est_active ? 'text-success' : 'text-secondary' }}">
                                        {{ $activite->est_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </label>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info rounded-pill">
                                {{ $activite->documents_count }}
                            </span>
                        </td>
                        <td>
                            {{ $activite->created_at->format('d/m/Y') }}
                        </td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('back.activites.edit', $activite) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger delete-activity"
                                        data-id="{{ $activite->id }}"
                                        data-nom="{{ $activite->nom }}"
                                        title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-3"></i>
                            <p>Aucune activité trouvée</p>
                            <a href="{{ route('back.activites.create') }}" class="btn btn-sm btn-primary">
                                Créer une première activité
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination si nécessaire -->
        @if($activites->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $activites->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle switch avec style Bluetooth
    $('.toggle-status').on('change', function() {
        const activiteId = $(this).data('activite-id');
        const isChecked = $(this).is(':checked');
        const label = $(this).next('.form-check-label').find('span');
        
        // Animation visuelle
        $(this).prop('disabled', true);
        label.text('Chargement...').removeClass('text-success text-secondary');
        
        // Envoi AJAX
        $.ajax({
            url: "{{ route('back.activites.toggle', '') }}/" + activiteId,
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
                const checkbox = $('.toggle-status[data-activite-id="' + activiteId + '"]');
                checkbox.prop('checked', !isChecked);
                toastr.error('Erreur lors de la mise à jour');
            },
            complete: function() {
                $('.toggle-status').prop('disabled', false);
            }
        });
    });
    
    // Confirmation suppression
    $('.delete-activity').on('click', function() {
        const activiteId = $(this).data('id');
        const activiteNom = $(this).data('nom');
        
        Swal.fire({
            title: 'Confirmer la suppression',
            html: `Êtes-vous sûr de vouloir supprimer l'activité <strong>"${activiteNom}"</strong> ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Soumission du formulaire de suppression
                const form = $('<form>', {
                    'method': 'POST',
                    'action': "{{ route('back.activites.destroy', '') }}/" + activiteId
                });
                
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': "{{ csrf_token() }}"
                }));
                
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_method',
                    'value': 'DELETE'
                }));
                
                $(document.body).append(form);
                form.submit();
            }
        });
    });
    
    // Style custom pour les switches
    $('.form-check-input').each(function() {
        const $this = $(this);
        if ($this.is(':checked')) {
            $this.css('background-color', '#0d6efd');
            $this.css('border-color', '#0d6efd');
        }
    });
});
</script>

<style>
/* Style custom pour les switches */
.form-check-input:checked {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
}

.form-check-input:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-check-input {
    width: 3em !important;
    height: 1.5em !important;
    transition: all 0.3s ease;
}

/* Style spécifique pour le switch désactivé */
.form-check-input:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Effet hover */
.form-check-input:hover:not(:disabled) {
    transform: scale(1.05);
}
</style>
@endpush