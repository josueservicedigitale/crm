export default function chat(conversationId, otherUser, currentUser, initialMessages) {
    return {
        messages: Array.isArray(initialMessages) ? initialMessages : [],
        
        // ... autres données
        
        // ✅ Méthode d'upload corrigée
        uploadFile(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            // Vérifier la taille (max 10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('Fichier trop volumineux (max 10MB)');
                return;
            }
            
            this.uploading = true;
            const formData = new FormData();
            formData.append('file', file);
            
            // Afficher un aperçu immédiat (optionnel)
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewImage = e.target.result;
                };
                reader.readAsDataURL(file);
            }
            
            fetch(`/back/conversations/${this.conversationId}/upload`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
                console.log('✅ Upload réussi:', message);
                
                // ✅ S'assurer que messages est un tableau
                if (!Array.isArray(this.messages)) {
                    this.messages = [];
                }
                
                // Ajouter le message avec le fichier
                this.messages.push({
                    id: message.id,
                    body: message.body || '',
                    file_path: message.file_path,
                    file_name: message.file_name,
                    file_type: message.file_type,
                    file_size: message.file_size,
                    file_url: message.file_url,
                    file_icon: message.file_icon,
                    formatted_size: message.formatted_size,
                    user_id: message.user_id,
                    user: message.user || { id: this.currentUser.id, name: this.currentUser.name },
                    created_at: new Date().toISOString()
                });
                
                this.uploading = false;
                this.previewImage = null;
                event.target.value = ''; // Reset input
                this.scrollToBottom();
            })
            .catch(err => {
                console.error('❌ Erreur upload:', err);
                this.uploading = false;
                alert('Erreur upload: ' + err.message);
            });
        },
        
        // ✅ Méthode sendMessage corrigée
        sendMessage() {
            if (!this.newMessage?.trim() || this.sending || this.uploading) return;
            
            this.sending = true;
            
            fetch(`/back/conversations/${this.conversationId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ body: this.newMessage })
            })
            .then(res => res.json())
            .then(message => {
                // ✅ S'assurer que messages est un tableau
                if (!Array.isArray(this.messages)) {
                    this.messages = [];
                }
                
                this.messages.push({
                    id: message.id,
                    body: message.body,
                    user_id: message.user_id,
                    user: message.user || { id: this.currentUser.id, name: this.currentUser.name },
                    created_at: new Date().toISOString()
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
        
        // ✅ Dans init(), vérifier que messages est un tableau
        init() {
            console.log('✅ Alpine chat initialisé', this.conversationId);
            
            // 🔥 FORCER messages à être un tableau
            if (!Array.isArray(this.messages)) {
                console.warn('⚠️ messages n\'est pas un tableau, conversion...', this.messages);
                this.messages = [];
            }
            
            // Formater les dates des messages existants
            this.messages = this.messages.map(msg => ({
                ...msg,
                created_at: msg.created_at ? new Date(msg.created_at) : new Date()
            }));
            
            this.scrollToBottom();
            this.listenForMessages();
            this.listenForTyping();
            this.listenForPresence();
            
            // Marquer comme lu
            if (this.conversationId) {
                fetch(`/back/conversations/${this.conversationId}/read`, {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            }
        }
    }
    
}