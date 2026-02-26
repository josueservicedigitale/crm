@extends('back.layouts.principal')

@section('title', 'Conversation avec ' . ($otherUser->name ?? ''))

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4"
         x-data="chat(@js($conversation->id), @js($otherUser), @js(auth()->user()), @js($messages))"
         x-init="init()">

        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('back.messagerie.index') }}" class="btn btn-sm btn-outline-light me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <div class="position-relative">
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

            <span class="badge bg-info p-2">
                <i class="fas fa-comments me-1"></i> {{ $conversation->created_at->format('d/m/Y') }}
            </span>
        </div>

        <!-- Messages -->
        <div class="chat-messages mb-3 p-3 bg-dark rounded"
             style="height: 420px; overflow-y: auto;"
             x-ref="messagesContainer">

            <template x-for="message in messages" :key="message.id">
                <div class="d-flex mb-3"
                     :class="message.user_id === currentUser.id ? 'justify-content-end' : 'justify-content-start'">

                    <div class="position-relative" style="max-width: 75%;">

                        <div class="rounded p-2"
                             :class="message.user_id === currentUser.id ? 'bg-primary' : 'bg-secondary'">

                            <!-- Reply preview inside message -->
                            <template x-if="message.reply_to">
                                <div class="bg-dark bg-opacity-25 rounded p-2 mb-2 small border-start border-3 border-info">
                                    <div class="fw-semibold text-white-50">
                                        Réponse à
                                        <span x-text="message.reply_to.user_id === currentUser.id ? 'vous' : otherUser.name"></span>
                                    </div>
                                    <div class="text-white"
                                         x-text="message.reply_to.body ? message.reply_to.body : (message.reply_to.file_name ? '📎 ' + message.reply_to.file_name : 'Message')">
                                    </div>
                                </div>
                            </template>

                            <!-- Text -->
                            <p x-show="message.body" class="mb-1 text-white" x-text="message.body"></p>

                            <!-- File -->
                            <div x-show="message.file_path" class="mb-1">
                                <template x-if="message.file_type?.startsWith('image/')">
                                    <a :href="message.file_url" target="_blank">
                                        <img :src="message.file_url" class="img-fluid rounded" style="max-height: 220px;"
                                             :alt="message.file_name">
                                    </a>
                                </template>

                                <template x-if="message.file_type?.startsWith('video/')">
                                    <video controls class="w-100 rounded" style="max-height: 220px;">
                                        <source :src="message.file_url" :type="message.file_type">
                                    </video>
                                </template>

                                <template x-if="message.file_path && !message.file_type?.startsWith('image/') && !message.file_type?.startsWith('video/')">
                                    <a :href="message.file_url" target="_blank"
                                       class="d-flex align-items-center p-2 bg-dark bg-opacity-25 rounded text-decoration-none">
                                        <i class="fas fa-file me-2 fa-2x text-white-50"></i>
                                        <div class="flex-grow-1">
                                            <div class="text-white small" x-text="message.file_name"></div>
                                            <div class="text-muted small" x-text="formatSize(message.file_size)"></div>
                                        </div>
                                        <i class="fas fa-download text-white ms-2"></i>
                                    </a>
                                </template>
                            </div>

                            <small class="opacity-75 d-block text-end text-white-50"
                                   x-text="formatTime(message.created_at)"></small>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-1 mt-1"
                             :class="message.user_id === currentUser.id ? 'justify-content-end' : 'justify-content-start'">

                            <button class="btn btn-sm btn-outline-light"
                                    @click="setReply(message)" title="Répondre">
                                <i class="fas fa-reply"></i>
                            </button>

                            <template x-if="message.user_id === currentUser.id">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-light" @click="startEdit(message)" title="Modifier">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" @click="deleteMsg(message)" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </template>

                        </div>

                    </div>
                </div>
            </template>

            <div x-show="messages.length === 0" class="text-center text-muted py-5">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>Aucun message. Commencez la discussion !</p>
            </div>
        </div>

        <!-- ✅ Mode Banner (Reply/Edit) -->
        <div x-show="mode !== 'send'" class="alert py-2 mb-2 d-flex justify-content-between align-items-center"
             :class="mode === 'edit' ? 'alert-warning' : 'alert-info'">

            <div class="text-truncate" style="max-width: 85%;">
                <template x-if="mode === 'edit'">
                    <span><i class="fas fa-pen me-2"></i> Modification du message</span>
                </template>

                <template x-if="mode === 'reply'">
                    <span>
                        <i class="fas fa-reply me-2"></i> Répondre à :
                        <span class="fw-semibold" x-text="replyTarget?.user_id === currentUser.id ? 'vous' : otherUser.name"></span>
                        —
                        <span x-text="replyTarget?.body ? replyTarget.body : (replyTarget?.file_name ? '📎 ' + replyTarget.file_name : 'Message')"></span>
                    </span>
                </template>
            </div>

            <button class="btn btn-sm btn-outline-dark" @click="cancelMode()">Annuler</button>
        </div>

        <!-- File preview -->
        <div x-show="previewImage" class="mb-2 position-relative">
            <div class="bg-dark p-2 rounded">
                <img :src="previewImage" class="img-fluid rounded" style="max-height: 120px;">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                        @click="removeFile()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

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

        <!-- ✅ ONE INPUT ONLY -->
        <div class="input-group">
            <input type="file" x-ref="fileInput" class="d-none"
                   @change="handleFileSelect($event)"
                   accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.txt">

            <button class="btn btn-outline-light" type="button"
                    @click="$refs.fileInput.click()"
                    :disabled="sending">
                <i class="fas fa-paperclip"></i>
            </button>

            <textarea class="form-control" rows="1" style="resize:none"
                      placeholder="Écrivez votre message..."
                      x-model="newMessage"
                      @input="autosize($event)"
                      @keydown.enter.prevent="handleEnter($event)"
                      :disabled="sending"></textarea>

            <!-- ✅ Dynamic button -->
            <button class="btn"
                    :class="mode === 'edit' ? 'btn-warning' : (mode === 'reply' ? 'btn-info' : 'btn-primary')"
                    @click="submit()"
                    :disabled="isSubmitDisabled()">

                <template x-if="!sending">
                    <span>
                        <template x-if="mode === 'edit'">
                            <i class="fas fa-check me-1"></i> Enregistrer
                        </template>
                        <template x-if="mode === 'reply'">
                            <i class="fas fa-reply me-1"></i> Répondre
                        </template>
                        <template x-if="mode === 'send'">
                            <i class="fas fa-paper-plane me-1"></i> Envoyer
                        </template>
                    </span>
                </template>

                <template x-if="sending">
                    <i class="fas fa-spinner fa-spin"></i>
                </template>
            </button>
        </div>

    </div>
</div>
@endsection

@push('js')
<script>
function chat(conversationId, otherUser, currentUser, initialMessages) {
    return {
        conversationId,
        messages: Array.isArray(initialMessages) ? initialMessages : [],
        newMessage: '',
        selectedFile: null,
        previewImage: null,
        sending: false,

        // ✅ mode: send | reply | edit
        mode: 'send',
        replyTarget: null,
        editingMessageId: null,

        typingUser: null,

        currentUser: { id: currentUser?.id, name: currentUser?.name },
        otherUser: { id: otherUser?.id, name: otherUser?.name, avatar: otherUser?.avatar, online: false },

        init() {
            this.scrollToBottom();

            fetch(`/back/conversations/${this.conversationId}/read`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': this.csrf() }
            });
        },

        csrf() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        },

        // =========================
        // Modes
        // =========================
        setReply(message) {
            this.mode = 'reply';
            this.replyTarget = message;
            this.editingMessageId = null;
            this.$nextTick(() => this.focusInput());
        },

        startEdit(message) {
            this.mode = 'edit';
            this.editingMessageId = message.id;
            this.newMessage = message.body || '';
            this.replyTarget = null;
            this.removeFile(); // edit = texte only (pro)
            this.$nextTick(() => this.focusInput());
        },

        cancelMode() {
            this.mode = 'send';
            this.replyTarget = null;
            this.editingMessageId = null;
            this.newMessage = '';
            // on garde le fichier si tu veux, mais généralement on l’enlève :
            // this.removeFile();
        },

        focusInput() {
            const ta = this.$root.querySelector('textarea.form-control');
            if (ta) ta.focus();
        },

        // =========================
        // File
        // =========================
        handleFileSelect(e) {
            const file = e.target.files?.[0];
            if (!file) return;

            if (file.size > 10 * 1024 * 1024) {
                alert('Fichier trop volumineux (max 10MB)');
                this.$refs.fileInput.value = '';
                return;
            }

            this.selectedFile = file;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (ev) => this.previewImage = ev.target.result;
                reader.readAsDataURL(file);
            } else {
                this.previewImage = null;
            }

            // ✅ si on a un fichier, on reste en send ou reply, mais PAS edit
            if (this.mode === 'edit') this.cancelMode();
        },

        removeFile() {
            this.selectedFile = null;
            this.previewImage = null;
            if (this.$refs.fileInput) this.$refs.fileInput.value = '';
        },

        // =========================
        // Enter behavior
        // Shift+Enter newline
        // Enter submit
        // =========================
        handleEnter(e) {
            if (e.shiftKey) {
                this.newMessage += "\n";
                return;
            }
            this.submit();
        },

        autosize(e) {
            const el = e.target;
            el.style.height = 'auto';
            el.style.height = (el.scrollHeight) + 'px';
        },

        // =========================
        // Submit button state
        // =========================

        isSubmitDisabled() {
            if (this.sending) return true;

            const bodyTrim = (this.newMessage || '').trim();

            if (this.mode === 'edit') {
                return bodyTrim.length === 0; 
            }

            // send/reply
            return bodyTrim.length === 0 && !this.selectedFile;
        },

        // =========================

        // =========================


        async submit() {
            if (this.isSubmitDisabled()) return;
            if (this.sending) return;

            this.sending = true;
            try {
                if (this.mode === 'edit') {
                    const res = await fetch(`/back/conversations/${this.conversationId}/messages/${this.editingMessageId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrf()
                        },
                        body: JSON.stringify({ body: this.newMessage })
                    });

                    if (!res.ok) throw new Error('Erreur modification');

                    const updated = await res.json();

                    this.messages = this.messages.map(m =>
                        m.id === updated.id ? { ...m, body: updated.body, updated_at: updated.updated_at } : m
                    );

                    this.cancelMode();
                    return;
                }

                // send / reply
                const formData = new FormData();
                const bodyTrim = (this.newMessage || '').trim();

                // ✅ texte + fichier ensemble
                if (bodyTrim) formData.append('body', this.newMessage);
                if (this.selectedFile) formData.append('file', this.selectedFile);

                if (this.mode === 'reply' && this.replyTarget?.id) {
                    formData.append('reply_to_id', this.replyTarget.id);
                }

                const res = await fetch(`/back/conversations/${this.conversationId}/send`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': this.csrf() },
                    body: formData
                });

                if (!res.ok) {
                    const txt = await res.text();
                    throw new Error(txt.substring(0, 160));
                }

                const msg = await res.json();
                this.messages.push(msg);

                // reset
                this.newMessage = '';
                this.removeFile();
                this.mode = 'send';
                this.replyTarget = null;

                this.scrollToBottom();

            } catch (err) {
                console.error(err);
                alert('Erreur: ' + (err.message || 'envoi impossible'));
            } finally {
                this.sending = false;
            }
        },

        // =========================
        // Delete
        // =========================
        async deleteMsg(message) {
            if (!confirm('Supprimer ce message ?')) return;

            const res = await fetch(`/back/conversations/${this.conversationId}/messages/${message.id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': this.csrf() }
            });

            if (!res.ok) {
                alert('Erreur suppression');
                return;
            }

            this.messages = this.messages.filter(m => m.id !== message.id);

            // si on était en mode reply/edit sur ce message → reset
            if (this.replyTarget?.id === message.id) this.cancelMode();
            if (this.editingMessageId === message.id) this.cancelMode();
        },

        // =========================
        // Utils
        // =========================
        formatTime(date) {
            const d = typeof date === 'string' ? new Date(date) : date;
            if (!(d instanceof Date) || isNaN(d)) return '';
            return d.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
        },

        formatSize(bytes) {
            if (!bytes) return '';
            const kb = bytes / 1024;
            if (kb < 1024) return Math.round(kb) + ' Ko';
            return (kb / 1024).toFixed(1) + ' Mo';
        },

        scrollToBottom() {
            setTimeout(() => {
                const c = this.$refs?.messagesContainer;
                if (c) c.scrollTop = c.scrollHeight;
            }, 50);
        },
    }
}
</script>
@endpush

@push('styles')
<style>
.chat-messages::-webkit-scrollbar { width: 5px; }
.chat-messages::-webkit-scrollbar-track { background: #343a40; }
.chat-messages::-webkit-scrollbar-thumb { background: #6c757d; border-radius: 5px; }
</style>
@endpush