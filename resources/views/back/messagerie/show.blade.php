@extends('back.layouts.principal')

@section('title', 'Conversation avec ' . ($otherUser->name ?? ''))

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4"
         x-data="chat(@js($conversation->id), @js($otherUser), @js(auth()->user()))"
         x-init="init()">

        <!-- En‑tête de la conversation -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('back.messagerie.index') }}" class="btn btn-sm btn-outline-light me-3"
                   data-bs-toggle="tooltip" title="Retour à la liste">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="position-relative" data-user-id="{{ $otherUser->id }}">
                    <img src="{{ $otherUser->avatar ? asset('storage/'.$otherUser->avatar) : asset('img/user.jpg') }}"
                         class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                    <span x-show="otherUser.online"
                          class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle"
                          style="width: 14px; height: 14px;"></span>
                </div>
                <div class="ms-3">
                    <h5 class="mb-0 text-white" x-text="otherUser.name"></h5>
                    <small class="text-muted">
                        <span x-show="typingUser" x-text="typingUser + ' écrit...'"></span>
                        <span x-show="otherUser.online && !typingUser">En ligne</span>
                        <span x-show="!otherUser.online && !typingUser">Hors ligne</span>
                    </small>
                </div>
            </div>
            <div>
                <span class="badge bg-info p-2">
                    <i class="fas fa-comments me-1"></i> {{ $conversation->created_at->format('d/m/Y') }}
                </span>
            </div>
        </div>

        <!-- Zone des messages -->
        <div class="chat-messages mb-4 p-3 bg-dark rounded"
             style="height: 400px; overflow-y: auto;"
             x-ref="messagesContainer">
            <template x-for="message in messages" :key="message.id">
                <div class="d-flex mb-3"
                     :class="message.user.id === currentUser.id ? 'justify-content-end' : 'justify-content-start'">
                    <div class="rounded p-2"
                         :class="message.user.id === currentUser.id ? 'bg-primary' : 'bg-secondary'"
                         style="max-width: 70%;">
                        <p class="mb-0 text-white" x-text="message.body"></p>
                        <small class="opacity-75 d-block text-end"
                               x-text="formatTime(message.created_at)"></small>
                    </div>
                </div>
            </template>
            <div x-show="messages.length === 0" class="text-center text-muted py-5">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>Aucun message. Commencez la discussion !</p>
            </div>
        </div>

        <!-- Zone de saisie -->
        <div class="input-group">
            <input type="text"
                   class="form-control"
                   placeholder="Écrivez votre message..."
                   x-model="newMessage"
                   @keydown="typing()"
                   @keydown.enter.prevent="sendMessage()"
                   :disabled="sending">
            <button class="btn btn-primary"
                    @click="sendMessage()"
                    :disabled="!newMessage.trim() || sending">
                <i class="fas fa-paper-plane"></i> Envoyer
            </button>
        </div>
    </div>
</div>
@endsection

<script>
function chat(conversationId, otherUser, currentUser) {
    return {
        // ✅ Données initialisées avec des valeurs par défaut
        conversationId: conversationId,
        otherUser: {
            id: otherUser?.id || null,
            name: otherUser?.name || 'Inconnu',
            avatar: otherUser?.avatar || null,
            online: false
        },
        currentUser: {
            id: currentUser?.id || null,
            name: currentUser?.name || 'Moi'
        },
        messages: @json($messages->items() ?? []), // ✅ Tableau même si vide
        newMessage: '',
        sending: false,
        typingUser: null,
        typingTimer: null,

        // ✅ Initialisation
        init() {
            console.log('✅ Alpine chat initialisé', this.conversationId);
            this.scrollToBottom();
            this.listenForMessages();
            this.listenForTyping();
            this.listenForPresence();
            
            // Marquer comme lu
            if (this.conversationId) {
                fetch(`/back/conversations/${this.conversationId}/read`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
            }
        },

        // ✅ Envoyer un message
        sendMessage() {
            console.log('📤 Envoi message:', this.newMessage);
            
            if (!this.newMessage?.trim() || this.sending) return;

            this.sending = true;
            fetch(`/back/conversations/${this.conversationId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ body: this.newMessage })
            })
            .then(res => res.json())
            .then(message => {
                this.messages.push({
                    id: message.id,
                    body: message.body,
                    created_at: new Date().toISOString(),
                    user: { id: this.currentUser.id, name: this.currentUser.name }
                });
                this.newMessage = '';
                this.sending = false;
                this.scrollToBottom();
            })
            .catch(err => {
                console.error('❌ Erreur envoi:', err);
                this.sending = false;
                alert('Erreur: ' + err.message);
            });
        },

        // ✅ Indicateur de frappe
        typing() {
            if (!this.conversationId) return;
            
            if (this.typingTimer) clearTimeout(this.typingTimer);
            
            fetch(`/back/conversations/${this.conversationId}/typing`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ is_typing: true })
            });
            
            this.typingTimer = setTimeout(() => {
                fetch(`/back/conversations/${this.conversationId}/typing`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ is_typing: false })
                });
            }, 2000);
        },

        // ✅ Écouter les nouveaux messages
        listenForMessages() {
            if (!window.Echo || !this.conversationId) return;
            
            window.Echo.private(`conversation.${this.conversationId}`)
                .listen('.message.sent', (e) => {
                    if (e.user_id !== this.currentUser.id) {
                        this.messages.push({
                            id: e.id,
                            body: e.body,
                            created_at: e.created_at,
                            user: { id: e.user_id, name: e.user_name }
                        });
                        this.scrollToBottom();
                    }
                });
        },

        // ✅ Écouter la frappe
        listenForTyping() {
            if (!window.Echo || !this.conversationId) return;
            
            window.Echo.private(`conversation.${this.conversationId}`)
                .listen('.user.typing', (e) => {
                    if (e.user_id !== this.currentUser.id) {
                        this.typingUser = e.is_typing ? e.user_name : null;
                    }
                });
        },

        // ✅ Présence en ligne
        listenForPresence() {
            if (!window.Echo) return;
            
            window.Echo.join('presence-online')
                .here((users) => {
                    this.otherUser.online = users.some(u => u.id === this.otherUser.id);
                })
                .joining((user) => {
                    if (user.id === this.otherUser.id) this.otherUser.online = true;
                })
                .leaving((user) => {
                    if (user.id === this.otherUser.id) this.otherUser.online = false;
                });
        },

        // ✅ Scroll automatique
        scrollToBottom() {
            setTimeout(() => {
                const container = this.$refs?.messagesContainer;
                if (container) container.scrollTop = container.scrollHeight;
            }, 50);
        },

        // ✅ Format heure
        formatTime(timestamp) {
            if (!timestamp) return '';
            const date = new Date(timestamp);
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    }
}
</script>