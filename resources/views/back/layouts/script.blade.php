<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('lib/chart/chart.min.js') }}"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
<script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
<script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Template Javascript -->
<script src="{{ asset('assets/js/main.js') }}"></script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
      var tooltipTriggerList = [].slice.call(
         document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );

      tooltipTriggerList.map(function (tooltipTriggerEl) {
         return new bootstrap.Tooltip(tooltipTriggerEl);
      });
   });
</script>



<script>
    // Mettre à jour les points verts en fonction du statut en ligne
    function updateOnlineStatus(onlineUsers) {
        document.querySelectorAll('[data-user-id]').forEach(el => {
            const userId = parseInt(el.dataset.userId);
            const isOnline = onlineUsers.some(u => u.id === userId);
            const dot = el.querySelector('.online-dot');
            if (dot) {
                dot.style.display = isOnline ? 'block' : 'none';
            }
        });
    }

    window.addEventListener('online-users-updated', (e) => {
        updateOnlineStatus(e.detail);
    });

    // Initialiser avec les utilisateurs déjà présents
    document.addEventListener('DOMContentLoaded', () => {
        if (window.onlineUsers) {
            updateOnlineStatus(window.onlineUsers);
        }
    });
    

</script>





