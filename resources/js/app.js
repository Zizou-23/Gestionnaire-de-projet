import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
window.Echo.channel('tasks')
    .listen('.task.status.updated', (e) => {
        console.log('Statut mis à jour :', e.task);
        // Afficher une notification, rafraîchir une liste, etc.
    });

