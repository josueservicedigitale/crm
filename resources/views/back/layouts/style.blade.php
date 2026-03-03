<!-- Favicon -->
<link href="{{ asset('assets/img/favicon.ico') }}" rel="icon">

<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Icon Font Stylesheet -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Libraries Stylesheet -->
<link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

<!-- Customized Bootstrap Stylesheet -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
<script src="//unpkg.com/alpinejs" defer></script>


<!-- Template Stylesheet -->
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
<style>
.badge-pulse {
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(220,53,69, 0.7);
    }
    70% {
        transform: scale(1.1);
        box-shadow: 0 0 0 10px rgba(220,53,69, 0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(220,53,69, 0);
    }
}


.sticky-search-wrapper {
    position: sticky;
    top: 15px; /* distance du haut */
    z-index: 1020;
}

.sticky-search-wrapper .card {
    background: #ffffff;
}


</style>