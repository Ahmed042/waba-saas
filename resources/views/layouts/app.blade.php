<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Gantari:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Vite + Livewire -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Gantari', sans-serif;
        }
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: #f8f9fa;
            padding: 20px;
            border-right: 1px solid #dee2e6;
        }
        .sidebar .logo {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .sidebar .nav-link {
            color: #333;
            font-weight: 500;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
            color: #0d6efd;
        }
        .sidebar .nav-group {
            margin-bottom: 20px;
        }
        .sidebar .nav-group-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
    </style>
</head>
<body class="font-sans antialiased">

    <x-banner />

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <i class="bi bi-robot"></i> Rubatt Bot
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Main</div>
                <a href="#" class="nav-link"><i class="bi bi-house"></i> Dashboard</a>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Client Management</div>
                <a href="#" class="nav-link"><i class="bi bi-people"></i> Clients</a>
                <a href="#" class="nav-link"><i class="bi bi-person-lines-fill"></i> Assign Subscriptions</a>
                <a href="#" class="nav-link"><i class="bi bi-key"></i> API Credentials</a>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Bot Configuration</div>
                <a href="#" class="nav-link"><i class="bi bi-sliders2"></i> Behavior Settings</a>
                <a href="#" class="nav-link"><i class="bi bi-translate"></i> Voice & Language</a>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Usage Analytics</div>
                <a href="#" class="nav-link"><i class="bi bi-bar-chart"></i> Message Stats</a>
                <a href="#" class="nav-link"><i class="bi bi-clock-history"></i> API Usage Logs</a>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">System Monitoring</div>
                <a href="#" class="nav-link"><i class="bi bi-exclamation-triangle"></i> Error Logs</a>
                <a href="#" class="nav-link"><i class="bi bi-cpu"></i> Server Health</a>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Billing & Subscriptions</div>
                <a href="#" class="nav-link"><i class="bi bi-cash"></i> Invoices</a>
                <a href="#" class="nav-link"><i class="bi bi-credit-card"></i> Payments</a>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Notifications</div>
                <a href="#" class="nav-link"><i class="bi bi-bell"></i> Alerts</a>
                <a href="#" class="nav-link"><i class="bi bi-envelope"></i> Email Triggers</a>
            </div>

            <div class="nav-group">
                <div class="nav-group-title">Settings</div>
                <a href="#" class="nav-link"><i class="bi bi-gear"></i> System Settings</a>
                <a href="#" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4 bg-light">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow mb-4">
                    <div class="container-fluid py-3 px-4">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot ?? '' }}
            </main>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
</body>
</html>
