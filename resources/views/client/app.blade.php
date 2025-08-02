<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Client Portal' }} | {{ strtoupper($company ?? '') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN + Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background: #f7f9fb; font-family: 'Segoe UI', 'Roboto', Arial, sans-serif; }
        .sidebar {
            min-height: 100vh;
            background: #fff;
            box-shadow: 2px 0 8px rgba(44,62,80,.04);
            border-right: 1px solid #f1f3f7;
            padding: 1.2rem 0;
        }
        .sidebar .nav-link {
            color: #495057;
            font-weight: 500;
            padding: .9rem 1.5rem;
            border-radius: 8px;
            transition: background 0.18s, color 0.18s;
            display: flex;
            align-items: center;
            gap: .8rem;
            margin-bottom: 6px;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: linear-gradient(90deg,#e6f0fa,#f3f8fe 70%);
            color: #2573e6;
        }
        .sidebar .nav-title {
            font-size: .94rem;
            color: #b0b4bb;
            text-transform: uppercase;
            font-weight: 700;
            margin: 1.7rem 1.5rem .6rem 1.5rem;
            letter-spacing: .04em;
        }
        .sidebar-logo {
            font-size: 1.7rem;
            font-weight: 700;
            color: #2573e6;
            letter-spacing: 1px;
            margin-bottom: 1.7rem;
            text-align: center;
        }
        .sidebar-footer {
            position: absolute;
            bottom: 30px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: .96rem;
            color: #c3c8d1;
        }
        @media (max-width: 991.98px) {
            .sidebar { min-height: auto; }
            .sidebar-logo { font-size: 1.15rem; }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <nav class="sidebar d-flex flex-column position-relative" style="width: 245px;">
            <div class="sidebar-logo mb-4">Rubatt<span style="color:#38b6ff;">Bot</span></div>
            <a href="/{{ $company }}/dashboard" class="nav-link{{ request()->is("$company/dashboard") ? ' active' : '' }}">
                <i class="bi bi-bar-chart-line"></i> Dashboard
            </a>

            <div class="nav-title">Messaging</div>
            <a href="/{{ $company }}/contacts" class="nav-link{{ request()->is("$company/contacts") ? ' active' : '' }}">
                <i class="bi bi-person-lines-fill"></i> Contacts
            </a>
            <a href="/{{ $company }}/lists" class="nav-link{{ request()->is("$company/lists") ? ' active' : '' }}">
                <i class="bi bi-diagram-3"></i> Lists & Segments
            </a>
            <a href="/{{ $company }}/send-message" class="nav-link{{ request()->is("$company/send-message") ? ' active' : '' }}">
                <i class="bi bi-send"></i> Send Message
            </a>
            <a href="/{{ $company }}/templates" class="nav-link{{ request()->is("$company/templates") ? ' active' : '' }}">
                <i class="bi bi-collection"></i> Templates
            </a>
            <a href="/{{ $company }}/inbox" class="nav-link{{ request()->is("$company/inbox") ? ' active' : '' }}">
                <i class="bi bi-chat-dots"></i> Inbox
            </a>

            <div class="nav-title">Insights</div>
            <a href="/{{ $company }}/usage" class="nav-link{{ request()->is("$company/usage") ? ' active' : '' }}">
                <i class="bi bi-pie-chart"></i> Usage & Quota
            </a>
            <a href="/{{ $company }}/audit-logs" class="nav-link{{ request()->is("$company/audit-logs") ? ' active' : '' }}">
                <i class="bi bi-list-check"></i> Audit Logs
            </a>

            <div class="nav-title">Account</div>
            <a href="/{{ $company }}/settings" class="nav-link{{ request()->is("$company/settings") ? ' active' : '' }}">
                <i class="bi bi-gear"></i> Settings
            </a>
            <a href="/{{ $company }}/logout" class="nav-link">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>

            <div class="sidebar-footer d-none d-md-block">
                &copy; {{ now()->year }} Rubatt.com
            </div>
        </nav>
        <main class="flex-fill" style="min-height: 100vh;">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
