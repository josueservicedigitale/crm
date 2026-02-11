@extends('back.layouts.principal')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <!-- En-tête -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-0 text-white">
                    <i class="fas fa-users me-2 text-primary"></i>👥 Gestion des Utilisateurs
                </h4>
                <small class="text-muted">Administration des comptes et rôles</small>
            </div>
            <a href="{{ route('back.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouvel Utilisateur
            </a>
        </div>

        <!-- Statistiques -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6">
                <div class="bg-dark rounded p-3">
                    <h6 class="text-white mb-2">Total</h6>
                    <h3 class="text-primary mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="bg-dark rounded p-3">
                    <h6 class="text-white mb-2">Actifs</h6>
                    <h3 class="text-success mb-0">{{ $stats['actifs'] }}</h3>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="bg-dark rounded p-3">
                    <h6 class="text-white mb-2">Inactifs</h6>
                    <h3 class="text-secondary mb-0">{{ $stats['inactifs'] }}</h3>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="bg-dark rounded p-3">
                    <h6 class="text-white mb-2">Admins</h6>
                    <h3 class="text-warning mb-0">{{ $stats['admins'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="table-responsive">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Utilisateur</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rôle</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Dernière connexion</th>
                        <th scope="col">Inscription</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="{{ $user->trashed() ? 'text-muted opacity-50' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-2 me-2"
                                     style="background-color: #{{ substr(md5($user->email), 0, 6) }}; width: 40px; height: 40px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->telephone)
                                        <br><small class="text-muted">{{ $user->telephone }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-warning text-dark">Admin</span>
                            @else
                                <span class="badge bg-info">Utilisateur</span>
                            @endif
                        </td>
                        <td>
                            @if($user->trashed())
                                <span class="badge bg-danger">Supprimé</span>
                            @else
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-user-status"
                                           type="checkbox"
                                           role="switch"
                                           data-user-id="{{ $user->id }}"
                                           id="toggle{{ $user->id }}"
                                           {{ $user->est_actif ? 'checked' : '' }}
                                           {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="toggle{{ $user->id }}">
                                        <span class="{{ $user->est_actif ? 'text-success' : 'text-secondary' }}">
                                            {{ $user->est_actif ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </label>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($user->derniere_connexion)
                                <small>{{ $user->derniere_connexion->diffForHumans() }}</small>
                            @else
                                <small class="text-muted">Jamais</small>
                            @endif
                        </td>
                        <td>
                            <small>{{ $user->created_at->format('d/m/Y') }}</small>
                        </td>
                       <td class="text-end">
    <div class="btn-group" role="group">
        {{-- 🔥 NOUVEAU : Bouton pour démarrer une conversation --}}
        @if($user->id !== auth()->id() && !$user->trashed())
            <a href="{{ route('back.messagerie.start', $user) }}" 
               class="btn btn-sm btn-outline-info"
               data-bs-toggle="tooltip"
               title="Démarrer une conversation">
                <i class="fas fa-comment"></i>
            </a>
        @endif

        {{-- Actions existantes --}}
        <a href="{{ route('back.users.edit', $user->id) }}"
           class="btn btn-sm btn-outline-warning" title="Modifier">
            <i class="fas fa-edit"></i>
        </a>

        @if($user->id !== auth()->id())
            <form action="{{ route('back.users.destroy', $user->id) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Déplacer {{ addslashes($user->name) }} vers la corbeille ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        @endif
    </div>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-user-slash fa-2x mb-3"></i>
                            <p>Aucun utilisateur trouvé</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle statut utilisateur
    $('.toggle-user-status').on('change', function() {
        const checkbox = $(this);
        const userId = checkbox.data('user-id');
        const label = checkbox.next('.form-check-label').find('span');
        const newState = checkbox.is(':checked');

        checkbox.prop('disabled', true);
        label.text('...').removeClass('text-success text-secondary');

        $.ajax({
            url: "{{ url('back/users') }}/" + userId + "/toggle-status",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    label.text(response.est_actif ? 'Actif' : 'Inactif')
                         .removeClass('text-success text-secondary')
                         .addClass(response.est_actif ? 'text-success' : 'text-secondary');
                    toastr.success(response.message);
                } else {
                    checkbox.prop('checked', !newState);
                    toastr.error(response.message || 'Erreur');
                }
            },
            error: function() {
                checkbox.prop('checked', !newState);
                toastr.error('Erreur de connexion');
            },
            complete: function() {
                checkbox.prop('disabled', false);
            }
        });
    });
});
</script>
@endpush