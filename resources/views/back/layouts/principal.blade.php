<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS additionnel depuis les pages -->
    @stack('css')

    <!-- Styles communs -->
    @include('back.layouts.style')
    <script>
    window.currentUserId = {{ auth()->id() ?? 'null' }};
</script>
</head>

<body>

    <!-- Sidebar -->
    @include('back.layouts.sidebar')

    <!-- Header / Topbar -->
    @include('back.layouts.header')

    <!-- Contenu principal -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('back.layouts.footer')

    <!-- Scripts communs -->
    @include('back.layouts.script')

    <!-- Scripts additionnels depuis les pages -->
    @stack('js')

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

</body>
</html>
