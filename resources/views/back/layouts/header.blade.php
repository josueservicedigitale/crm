
<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
    </a>

    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>

    <form class="d-none d-md-flex ms-4">
        <input class="form-control border-0" type="search" placeholder="Search">
    </form>

    <div class="navbar-nav align-items-center ms-auto">




        <!-- Messages Dropdown -->
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-envelope me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Messages</span>
                @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                    <span class="badge bg-danger rounded-pill ms-1">{{ $unreadMessagesCount }}</span>
                @endif
            </a>

            {{-- ✅ UN SEUL dropdown-menu, avec le contenu réel --}}
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0"
                style="width: 320px; max-height: 400px; overflow-y: auto;">
                @forelse($conversations ?? [] as $conv)
                    @php
                        $otherUser = $conv->users->first();
                        $lastMsg = $conv->lastMessage;
                        $isUnread = !$conv->users->find(auth()->id())->pivot->last_read_at ||
                            ($lastMsg && $lastMsg->created_at->gt($conv->users->find(auth()->id())->pivot->last_read_at));
                        $avatar = $otherUser->avatar ? asset('storage/' . $otherUser->avatar) : asset('img/user.jpg');
                        $isOnline = $otherUser->isOnline();
                    @endphp
                    <a href="{{ route('back.messagerie.show', $conv) }}"
                        class="dropdown-item {{ $isUnread ? 'fw-bold bg-light' : '' }}">
                        <div class="d-flex align-items-center">
                            <div class="position-relative" data-user-id="{{ $otherUser->id }}">
                                <img class="rounded-circle" src="{{ $avatar }}"
                                    style="width: 40px; height: 40px; object-fit: cover;">
                                @if($isOnline)
                                    <span
                                        class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle online-dot"
                                        style="width: 12px; height: 12px;"></span>
                                @endif
                            </div>
                            <div class="ms-2 flex-grow-1">
                                <h6 class="fw-normal mb-0">{{ $otherUser->name }}</h6>
                                <small class="text-muted">{{ Str::limit($lastMsg->body ?? 'Aucun message', 35) }}</small>
                            </div>
                            <div class="ms-2 text-end">
                                <small
                                    class="text-muted">{{ $lastMsg ? $lastMsg->created_at->diffForHumans() : '' }}</small>
                            </div>
                        </div>
                    </a>
                    @if(!$loop->last)
                        <hr class="dropdown-divider">
                    @endif
                @empty
                    <span class="dropdown-item-text text-muted text-center">Aucune conversation</span>
                @endforelse

                <div class="dropdown-divider"></div>
                <a href="{{ route('back.messagerie.index') }}" class="dropdown-item text-center">
                    Voir tous les messages
                </a>
            </div>
        </div>



        <!-- Notifications Dropdown -->
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-bell me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Notifications</span>
                @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                    <span class="badge bg-danger rounded-pill ms-1">{{ $unreadNotificationsCount }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0"
                style="width: 320px; max-height: 400px; overflow-y: auto;">
                @forelse($conversations ?? [] as $conv)
                    @php
                        // ✅ Interlocuteur (l'autre utilisateur)
                        $otherUser = $conv->users->where('id', '!=', auth()->id())->first();
                        // ✅ Participant courant (soi-même) – pour accéder au pivot
                        $currentUserPivot = $conv->users->find(auth()->id())?->pivot;

                        $lastMsg = $conv->lastMessage;
                        $isUnread = !$currentUserPivot?->last_read_at ||
                            ($lastMsg && $lastMsg->created_at->gt($currentUserPivot?->last_read_at));
                        $avatar = $otherUser->avatar ? asset('storage/' . $otherUser->avatar) : asset('img/user.jpg');
                        $isOnline = $otherUser?->isOnline() ?? false;
                    @endphp
                    @if($otherUser) {{-- Sécurité : si un interlocuteur existe --}}
                        <a href="{{ route('back.messagerie.show', $conv) }}"
                            class="dropdown-item {{ $isUnread ? 'fw-bold bg-light' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="position-relative" data-user-id="{{ $otherUser->id }}">
                                    <img class="rounded-circle" src="{{ $avatar }}"
                                        style="width: 40px; height: 40px; object-fit: cover;">
                                    @if($isOnline)
                                        <span
                                            class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle online-dot"
                                            style="width: 12px; height: 12px;"></span>
                                    @endif
                                </div>
                                <div class="ms-2 flex-grow-1">
                                    <h6 class="fw-normal mb-0">{{ $otherUser->name }}</h6>
                                    <small class="text-muted">{{ Str::limit($lastMsg->body ?? 'Aucun message', 35) }}</small>
                                </div>
                                <div class="ms-2 text-end">
                                    <small
                                        class="text-muted">{{ $lastMsg ? $lastMsg->created_at->diffForHumans() : '' }}</small>
                                </div>
                            </div>
                        </a>
                    @endif
                    @if(!$loop->last)
                        <hr class="dropdown-divider">
                    @endif
                @empty
                    <span class="dropdown-item-text text-muted text-center">Aucune conversation</span>
                @endforelse

                <div class="dropdown-divider"></div>
                <a href="{{ route('back.notifications.index') }}" class="dropdown-item text-center">
                    Voir toutes les notifications
                </a>
            </div>
        </div>



        <!-- User menu -->
        <div class="nav-item dropdown">
            <a href="{{ route('profile.edit') }}" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2" src="{{ asset('img/user.jpg') }}" alt="User"
                    style="width: 40px; height: 40px;">
                <span class="d-none d-lg-inline-flex">{{ auth()->user()->name ?? 'Utilisateur' }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="{{ route('profile.edit') }}" class="dropdown-item">{{ __('Profile') }}</a>
                <a href="#" class="dropdown-item">Settings</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fa fa-sign-out-alt me-2"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>
<!-- Navbar End -->