import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

// ✅ Seulement si l'utilisateur est connecté
if (window.currentUserId) {
    // 1. Rejoindre le canal de présence des utilisateurs en ligne
    window.Echo.join('presence-online')
        .here((users) => {
            window.onlineUsers = users;
            window.dispatchEvent(new CustomEvent('online-users-updated', { detail: users }));
        })
        .joining((user) => {
            window.onlineUsers.push(user);
            window.dispatchEvent(new CustomEvent('online-users-updated', { detail: window.onlineUsers }));
        })
        .leaving((user) => {
            window.onlineUsers = window.onlineUsers.filter(u => u.id !== user.id);
            window.dispatchEvent(new CustomEvent('online-users-updated', { detail: window.onlineUsers }));
        });

    // 2. Écouter les nouveaux messages sur le canal privé de l'utilisateur
    window.Echo.private(`user.${window.currentUserId}`)
        .listen('.message.sent', (e) => {
            // Recharger le dropdown des messages
            fetch('/back/messages/dropdown')
                .then(response => response.text())
                .then(html => {
                    const dropdown = document.querySelector('.messages-dropdown-menu');
                    if (dropdown) dropdown.innerHTML = html;
                    // Réappliquer les points verts après mise à jour
                    if (window.onlineUsers) {
                        window.dispatchEvent(new CustomEvent('online-users-updated', { detail: window.onlineUsers }));
                    }
                })
                .catch(err => console.error('Erreur rechargement dropdown:', err));
        });
}