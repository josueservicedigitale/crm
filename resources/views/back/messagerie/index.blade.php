@extends('back.layouts.principal')

@section('title', 'Mes conversations')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-0 text-white">
                        <i class="fas fa-comments me-2 text-info"></i>Mes conversations
                    </h4>
                    <small class="text-muted">Échangez avec vos collaborateurs et partenaires</small>
                </div>
                <div>
                    <a href="{{ route('back.users.index') }}" class="btn btn-sm btn-outline-light" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="Démarrer une nouvelle conversation">
                        <i class="fas fa-plus-circle me-1"></i>Nouvelle conversation
                    </a>
                    <a href="{{ route('home.dashboard') }}" class="btn btn-sm btn-outline-secondary ms-2"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Retour au tableau de bord">
                        <i class="fas fa-arrow-left me-1"></i>Retour
                    </a>
                </div>
            </div>

            @if($conversations->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>Aucune conversation pour le moment.</p>
                    <a href="{{ route('back.users.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Démarrer une conversation
                    </a>
                </div>
            @else
                <div class="list-group">
                    @foreach($conversations as $conv)
                        @php
                            // ✅ Interlocuteur (l'autre participant)
                            $otherUser = $conv->users->where('id', '!=', auth()->id())->first();
                            // ✅ Participant courant – pour accéder au pivot last_read_at
                            $currentUserPivot = $conv->users->find(auth()->id())?->pivot;

                            $lastMsg = $conv->lastMessage;
                            $isUnread = !$currentUserPivot?->last_read_at ||
                                ($lastMsg && $lastMsg->created_at->gt($currentUserPivot?->last_read_at));
                            $avatar = $otherUser?->avatar ? asset('storage/' . $otherUser->avatar) : asset('img/user.jpg');
                            $isOnline = $otherUser?->isOnline() ?? false;
                        @endphp

                        @if($otherUser) {{-- Sécurité : ne pas afficher si étrangement il n'y a pas d'autre participant --}}
                            <a href="{{ route('back.messagerie.show', $conv) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center
                              {{ request()->route('conversation') == $conv->id ? 'active' : '' }}
                              {{ $isUnread ? 'fw-bold bg-opacity-25' : '' }}">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3" data-user-id="{{ $otherUser->id }}">
                                        <img src="{{ $avatar }}" class="rounded-circle" width="50" height="50"
                                            style="object-fit: cover;">
                                        @if($isOnline)
                                            <span
                                                class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle online-dot"
                                                style="width: 14px; height: 14px;"></span>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $otherUser->name }}</h6>
                                        <small class="text-muted">
                                            {{ Str::limit($lastMsg->body ?? 'Aucun message', 50) }}
                                        </small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    @if($isUnread)
                                        <span class="badge bg-danger rounded-pill mb-1">Nouveau</span>
                                        <br>
                                    @endif
                                    <small class="text-muted" data-bs-toggle="tooltip"
                                        title="{{ $lastMsg ? $lastMsg->created_at->format('d/m/Y H:i') : '' }}">
                                        {{ $lastMsg ? $lastMsg->created_at->diffForHumans() : '' }}
                                    </small>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>

                <!-- Pagination (si nécessaire) -->
                @if(method_exists($conversations, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $conversations->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Activation des tooltips Bootstrap (si non déjà fait globalement)
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush