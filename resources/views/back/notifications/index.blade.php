@extends('back.layouts.principal')

@section('title', 'Toutes les notifications')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-0 text-white">
                    <i class="fas fa-bell me-2 text-warning"></i>Toutes les notifications
                </h4>
                <small class="text-muted">Historique et suivi des alertes</small>
            </div>
            <div>
                @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('back.notifications.read-all') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="Marquer toutes les notifications comme lues">
                        <i class="fas fa-check-double me-1"></i>Tout marquer comme lu
                    </button>
                </form>
                @endif
                <a href="{{ route('home.dashboard') }}" class="btn btn-sm btn-outline-secondary ms-2"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Retour au tableau de bord">
                    <i class="fas fa-arrow-left me-1"></i>Retour
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-dark align-middle">
                <thead>
                    <tr>
                        <th scope="col" width="60">#</th>
                        <th scope="col" width="80">Type</th>
                        <th scope="col">Message</th>
                        <th scope="col" width="180">Date</th>
                        <th scope="col" width="120">Statut</th>
                        <th scope="col" width="150" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                    <tr class="{{ $notification->read_at ? '' : 'fw-bold bg-opacity-25' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">
                            @php
                                $icon = $notification->data['icon'] ?? 'fa-bell';
                                $color = $notification->read_at ? 'secondary' : ($notification->data['color'] ?? 'primary');
                            @endphp
                            <span class="badge bg-{{ $color }} p-2" 
                                  data-bs-toggle="tooltip" 
                                  title="{{ ucfirst(str_replace('-', ' ', $notification->type ?? 'Notification')) }}">
                                <i class="fas {{ $icon }}"></i>
                            </span>
                        </td>
                        <td>
                            <div>
                                <strong>{{ $notification->data['title'] ?? 'Notification' }}</strong>
                                <br>
                                <small class="text-muted">{{ $notification->data['body'] ?? '' }}</small>
                            </div>
                        </td>
                        <td>
                            <span data-bs-toggle="tooltip" 
                                  title="{{ $notification->created_at->format('d/m/Y H:i:s') }}">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </td>
                        <td>
                            @if($notification->read_at)
                                <span class="badge bg-secondary" 
                                      data-bs-toggle="tooltip" 
                                      title="Lu le {{ $notification->read_at->format('d/m/Y H:i') }}">
                                    <i class="fas fa-check-circle me-1"></i>Lu
                                </span>
                            @else
                                <span class="badge bg-warning text-dark" 
                                      data-bs-toggle="tooltip" 
                                      title="Non lu">
                                    <i class="fas fa-circle me-1"></i>Nouveau
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                @if(!$notification->read_at)
                                <form action="{{ route('back.notifications.read', $notification->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-success"
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="top"
                                            title="Marquer comme lu">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                <a href="{{ $notification->data['url'] ?? '#' }}" 
                                   class="btn btn-sm btn-outline-info"
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="top"
                                   title="Voir le détail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-bell-slash fa-3x mb-3"></i>
                            <p>Aucune notification pour le moment.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
    // Activation des tooltips Bootstrap 5 (si non déjà fait globalement)
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush