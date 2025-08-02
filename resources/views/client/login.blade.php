<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | {{ strtoupper($company) }} Client Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e9ecef 100%);
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
        }
        .login-container {
            max-width: 410px;
            margin: 60px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 32px 0 rgba(0,0,0,0.07);
            padding: 2.5rem 2.5rem 2rem 2.5rem;
        }
        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #22223b;
            margin-bottom: .25rem;
        }
        .company-badge {
            font-size: 1.1rem;
            color: #4f8cfb;
            font-weight: 600;
            letter-spacing: 1.5px;
        }
        .form-label {
            font-weight: 500;
            color: #343a40;
        }
        .form-control {
            border-radius: 8px;
            min-height: 46px;
            font-size: 1.05rem;
        }
        .login-btn {
            background: linear-gradient(90deg,#4f8cfb,#38b6ff);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            font-size: 1.1rem;
            letter-spacing: 1px;
            box-shadow: 0 2px 16px 0 rgba(79,140,251,0.08);
            transition: background 0.2s;
        }
        .login-btn:hover {
            background: linear-gradient(90deg,#38b6ff,#4f8cfb);
        }
        .alert {
            font-size: 0.97rem;
        }
        @media (max-width: 600px) {
            .login-container {
                margin: 25px 10px;
                padding: 1.2rem 1.2rem 1rem 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="text-center mb-4">
            <div class="login-title">Welcome</div>
            <div class="company-badge">{{ strtoupper($company) }} Enterprise Portal</div>
            <div class="mt-2 text-muted" style="font-size: 1rem;">
                Secure login for authorized clients only.
            </div>
        </div>
        @if($errors->any())
            <div class="alert alert-danger mb-3">
                {!! implode('<br>', $errors->all()) !!}
            </div>
        @endif
        <form method="POST" action="{{ route('client.login.submit', ['company' => $company]) }}" autocomplete="off">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control shadow-sm" placeholder="you@company.com" required autofocus>
            </div>
            <div class="mb-2">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control shadow-sm" placeholder="********" required>
            </div>
            <div class="d-grid my-4">
                <button type="submit" class="btn login-btn py-2">Sign In</button>
            </div>
        </form>
        <div class="text-center text-muted" style="font-size:0.96rem;">
            &copy; {{ now()->year }} Rubatt.com &mdash; Enterprise SaaS Suite
        </div>
    </div>
</body>
</html>
