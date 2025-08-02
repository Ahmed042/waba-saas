<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Password | {{ strtoupper($company) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f7f9fb; }
        .box {
            max-width: 430px;
            margin: 60px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 32px 0 rgba(0,0,0,0.07);
            padding: 2.5rem 2.5rem 2rem 2.5rem;
        }
        .title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #22223b;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="text-center mb-4">
            <div class="title">Set Your New Password</div>
            <div class="text-muted" style="font-size: 1rem;">
                For your security, please create a new password before accessing your dashboard.
            </div>
        </div>
        @if($errors->any())
            <div class="alert alert-danger mb-3">
                {!! implode('<br>', $errors->all()) !!}
            </div>
        @endif
        <form method="POST" action="{{ route('client.password.update.submit', ['company' => $company]) }}" autocomplete="off">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="password">New Password</label>
                <input type="password" id="password" name="password" class="form-control shadow-sm" required minlength="8" placeholder="********">
            </div>
            <div class="mb-4">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control shadow-sm" required minlength="8" placeholder="********">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary py-2">Update Password</button>
            </div>
        </form>
        <div class="text-center text-muted mt-4" style="font-size:0.96rem;">
            &copy; {{ now()->year }} Rubatt.com &mdash; Enterprise SaaS Suite
        </div>
    </div>
</body>
</html>
