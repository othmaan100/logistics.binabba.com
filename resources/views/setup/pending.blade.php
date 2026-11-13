<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Setup in progress</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}?v={{ filemtime(public_path('css/theme.css')) }}" rel="stylesheet">
</head>
<body class="setup-page">
    <main class="setup-wrap setup-narrow">
        <div class="card text-center">
            <div class="card-body py-5 px-4">
                <span class="setup-pending-icon"><i class="fas fa-tools"></i></span>
                <h1 class="h4 mt-3">The system is being set up</h1>
                <p class="text-muted mb-4">
                    An administrator needs to enter the organization's details before the system can be used.
                    Please try again later, or ask your administrator to sign in and complete the setup.
                </p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Sign out</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
