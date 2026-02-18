import './bootstrap';

import Alpine from 'alpinejs'
import chat from './components/chat'

window.Alpine = Alpine

Alpine.data('chat', chat)

Alpine.start()



