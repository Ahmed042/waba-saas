<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Inbox | RubattBot')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Bootstrap, Bootstrap Icons, and your custom CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        html, body { height: 100%; margin:0; padding:0; background: #ece5dd; }
        /* You can also put the WhatsApp bg pattern here if you want it everywhere */
    </style>
    @stack('styles')
</head>
<body>
    {{-- Topbar or user dropdown if you want (optional) --}}
    <main>
        @yield('content')
    </main>
    {{-- JS libraries if needed --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
