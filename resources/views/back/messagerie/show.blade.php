@extends('back.layouts.principal')

@section('title', 'Conversation avec ' . ($otherUser->name ?? ''))

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4"
         x-data="chat(@js($conversation->id), @js($otherUser), @js(auth()->user()), @js($messages))"
         x-init="init()">

        <!-- En‑tête de la conversation -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('back.messagerie.index') }}" class="btn btn-sm btn-outline-light me-3"
                   data-bs-toggle="tooltip" title="Retour à la liste">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div class="position-relative" data-user-id="{{ $otherUser->id }}">
                    <img src="{{ $otherUser->avatar ? asset('storage/' . $otherUser->avatar) : asset('img/user.jpg') }}"
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
        <div class="chat-messages mb-4 p-3 bg-dark rounded" style="height: 400px; overflow-y: auto;"
             x-ref="messagesContainer">
            <template x-for="message in messages" :key="message.id">
                <div class="d-flex mb-3"
                     :class="message.user_id === currentUser.id ? 'justify-content-end' : 'justify-content-start'">
                    <div class="rounded p-2"
                         :class="message.user_id === currentUser.id ? 'bg-primary' : 'bg-secondary'"
                         style="max-width: 70%;">

                        <!-- Texte du message -->
                        <p x-show="message.body" class="mb-1 text-white" x-text="message.body"></p>

                        <!-- Fichier attaché -->
                        <div x-show="message.file_path" class="mb-1">
                            <template x-if="message.file_type?.startsWith('image/')">
                                <a :href="message.file_url" target="_blank">
                                    <img :src="message.file_url" class="img-fluid rounded" style="max-height: 200px;"
                                         :alt="message.file_name">
                                </a>
                            </template>

                            <template x-if="message.file_type?.startsWith('video/')">
                                <video controls class="w-100 rounded" style="max-height: 200px;">
                                    <source :src="message.file_url" :type="message.file_type">
                                </video>
                            </template>

                            <template
                                x-if="!message.file_type?.startsWith('image/') && !message.file_type?.startsWith('video/') && message.file_path">
                                <a :href="message.file_url" target="_blank"
                                   class="d-flex align-items-center p-2 bg-dark bg-opacity-25 rounded text-decoration-none">
                                    <i :class="'fas ' + message.file_icon + ' me-2 fa-2x'"></i>
                                    <div class="flex-grow-1">
                                        <div class="text-white small" x-text="message.file_name"></div>
                                        <div class="text-muted small" x-text="message.formatted_size"></div>
                                    </div>
                                    <i class="fas fa-download text-white ms-2"></i>
                                </a>
                            </template>
                        </div>

                        <!-- HORAIRE -->
                        <small class="opacity-75 d-block text-end text-white-50"
                               x-text="formatTime(message.created_at)"></small>
                    </div>
                </div>
            </template>
            <div x-show="messages.length === 0" class="text-center text-muted py-5">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>Aucun message. Commencez la discussion !</p>
            </div>
        </div>

        <!-- Zone de saisie avec upload -->
        <div class="position-relative">
            <!-- Prévisualisation de l'image -->
            <div x-show="previewImage" class="mb-2 position-relative">
                <div class="bg-dark p-2 rounded">
                    <img :src="previewImage" class="img-fluid rounded" style="max-height: 100px;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                            @click="removeFile()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Nom du fichier (pour les fichiers non-images) -->
            <div x-show="selectedFile && !previewImage" class="mb-2 p-2 bg-dark rounded">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file text-info me-2 fa-2x"></i>
                    <div class="flex-grow-1">
                        <div class="text-white small" x-text="selectedFile?.name"></div>
                        <div class="text-muted small" x-text="Math.round(selectedFile?.size / 1024) + ' Ko'"></div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" @click="removeFile()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Barre de progression -->
            <div x-show="uploadProgress > 0 && uploadProgress < 100" class="progress mb-2" style="height: 5px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                     :style="'width: ' + uploadProgress + '%'"></div>
            </div>

            <!-- Input group -->
            <div class="input-group">
                <!-- Input file avec x-ref -->
                <input type="file" x-ref="fileInput" class="d-none" 
                       @change="handleFileSelect($event)" 
                       accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.txt">

                <!-- Bouton avec $refs -->
                <button class="btn btn-outline-light" type="button" 
                        @click="$refs.fileInput.click()" 
                        :disabled="sending || uploading">
                    <i class="fas fa-paperclip"></i>
                </button>

                <input type="text" class="form-control" placeholder="Écrivez votre message..." 
                       x-model="newMessage"
                       @keydown="typing()" 
                       @keydown.enter.prevent="sendMessage()" 
                       :disabled="sending || uploading">

                <button class="btn btn-primary" @click="sendMessage()"
                        :disabled="(!newMessage.trim() && !selectedFile) || sending || uploading">
                    <i class="fas fa-paper-plane" x-show="!uploading"></i>
                    <i class="fas fa-spinner fa-spin" x-show="uploading"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function chat(conversationId, otherUser, currentUser, initialMessages) {
    return {
        // =============================
        // 🧠 STATE
        // =============================
        conversationId: conversationId,
        messages: Array.isArray(initialMessages) ? initialMessages.map(msg => ({
            ...msg,
            created_at: new Date(msg.created_at)
        })) : [],
        newMessage: '',
        selectedFile: null,
        previewImage: null,
        uploadProgress: 0,
        sending: false,
        uploading: false,
        dragOver: false,
        typingUser: null,
        typingTimer: null,

        currentUser: {
            id: currentUser?.id,
            name: currentUser?.name
        },
        otherUser: {
            id: otherUser?.id,
            name: otherUser?.name,
            avatar: otherUser?.avatar,
            online: false
        },

        // =============================
        // 🚀 INIT
        // =============================
        init() {
            console.log('✅ Chat initialisé', this.conversationId);
            this.scrollToBottom();
            this.listenForMessages();
            this.listenForTyping();
            this.listenForPresence();

            // Marquer comme lu
            if (this.conversationId) {
                fetch(`/back/conversations/${this.conversationId}/read`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') }
                });
            }
        },

        // =============================
        // 📁 SELECT FILE
        // =============================
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.prepareFile(file);
        },

        // =============================
        // 📦 PREPARE FILE
        // =============================
        prepareFile(file) {
            // Vérifier la taille (max 10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('Fichier trop volumineux (max 10MB)');
                return;
            }

            this.selectedFile = file;

            // Prévisualisation pour les images
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewImage = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        // =============================
        // ❌ REMOVE FILE
        // =============================
        removeFile() {
            this.selectedFile = null;
            this.previewImage = null;
            this.uploadProgress = 0;
            this.$refs.fileInput.value = '';
        },

        // =============================
        // 🚀 SEND MESSAGE (TEXTE + FICHIER)
        // =============================
        sendMessage() {
            if ((!this.newMessage.trim() && !this.selectedFile) || this.sending) return;

            this.sending = true;
            this.uploading = !!this.selectedFile;

            const formData = new FormData();
            
            // Ajouter le message si présent
            if (this.newMessage.trim()) {
                formData.append('body', this.newMessage);
            }
            
            // Ajouter le fichier si présent
            if (this.selectedFile) {
                formData.append('file', this.selectedFile);
            }

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            fetch(`/back/conversations/${this.conversationId}/send`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                body: formData
            })
            .then(async response => {
                if (!response.ok) {
                    const text = await response.text();
                    throw new Error(text.substring(0, 100));
                }
                return response.json();
            })
            .then(message => {
                message.created_at = new Date(message.created_at);
                this.messages.push(message);
                this.newMessage = '';
                this.removeFile();
                this.scrollToBottom();
                this.sending = false;
                this.uploading = false;
            })
            .catch(err => {
                console.error('❌ Erreur:', err);
                alert('Erreur: ' + err.message);
                this.sending = false;
                this.uploading = false;
                this.uploadProgress = 0;
            });
        },

        // =============================
        // 👨‍💻 TYPING INDICATOR
        // =============================
        typing() {
            if (!this.conversationId || !this.newMessage.trim()) return;

            if (this.typingTimer) clearTimeout(this.typingTimer);

            fetch(`/back/conversations/${this.conversationId}/typing`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({ is_typing: true })
            });

            this.typingTimer = setTimeout(() => {
                fetch(`/back/conversations/${this.conversationId}/typing`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    },
                    body: JSON.stringify({ is_typing: false })
                });
            }, 2000);
        },

        // =============================
        // 🎧 LISTENERS
        // =============================
        listenForMessages() {
            if (!window.Echo || !this.conversationId) return;

            window.Echo.private(`conversation.${this.conversationId}`)
                .listen('.message.sent', (e) => {
                    if (e.user_id !== this.currentUser.id) {
                        e.message.created_at = new Date(e.message.created_at);
                        this.messages.push(e.message);
                        this.scrollToBottom();
                    }
                });
        },

        listenForTyping() {
            if (!window.Echo || !this.conversationId) return;

            window.Echo.private(`conversation.${this.conversationId}`)
                .listen('.user.typing', (e) => {
                    if (e.user_id !== this.currentUser.id) {
                        this.typingUser = e.is_typing ? e.user_name : null;
                    }
                });
        },

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

        // =============================
        // 🔽 SCROLL
        // =============================
        scrollToBottom() {
            setTimeout(() => {
                const container = this.$refs?.messagesContainer;
                if (container) container.scrollTop = container.scrollHeight;
            }, 50);
        },

        // =============================
        // ⏰ FORMAT TIME
        // =============================
        formatTime(date) {
            if (!date) return '';
            const d = typeof date === 'string' ? new Date(date) : date;
            if (!(d instanceof Date) || isNaN(d)) return '';
            return d.toLocaleTimeString('fr-FR', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }
}
</script>

<style>
.chat-messages::-webkit-scrollbar {
    width: 5px;
}
.chat-messages::-webkit-scrollbar-track {
    background: #343a40;
}
.chat-messages::-webkit-scrollbar-thumb {
    background: #6c757d;
    border-radius: 5px;
}
</style>