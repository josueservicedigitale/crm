@forelse($conversations as $conv)
    @php
        $otherUser = $conv->users->first();
        $lastMsg = $conv->lastMessage;
        $isUnread = !$conv->users->find(auth()->id())->pivot->last_read_at ||
                    ($lastMsg && $lastMsg->created_at->gt($conv->users->find(auth()->id())->pivot->last_read_at));
        $avatar = $otherUser->avatar ? asset('storage/'.$otherUser->avatar) : asset('img/user.jpg');
        $isOnline = $otherUser->isOnline();
    @endphp
    <a href="{{ route('back.messagerie.show', $conv) }}" class="dropdown-item {{ $isUnread ? 'fw-bold bg-light' : '' }}">
        <div class="d-flex align-items-center">
            <div class="position-relative" data-user-id="{{ $otherUser->id }}">
                <img class="rounded-circle" src="{{ $avatar }}" alt="" style="width: 40px; height: 40px; object-fit: cover;">
                @if($isOnline)
                    <span class="online-dot position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle"
                          style="width: 12px; height: 12px;"></span>
                @endif
            </div>
            <div class="ms-2 flex-grow-1">
                <h6 class="fw-normal mb-0">{{ $otherUser->name }}</h6>
                <small class="text-muted">{{ Str::limit($lastMsg->body ?? 'Aucun message', 35) }}</small>
            </div>
            <div class="ms-2 text-end">
                <small class="text-muted">{{ $lastMsg ? $lastMsg->created_at->diffForHumans() : '' }}</small>
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
