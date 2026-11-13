<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Set up your organization</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}?v={{ filemtime(public_path('css/theme.css')) }}" rel="stylesheet">
</head>
<body class="setup-page">
    <main class="setup-wrap">
        <header class="setup-hero">
            <span class="setup-badge"><i class="fas fa-magic"></i> First-time setup</span>
            <h1>Set up your organization</h1>
            <p>
                Before the system can be used, enter your organization's details. They appear in the sidebar,
                on the sign-in page and on every invoice, report and PDF. You can change them later under
                <strong>System → Organization</strong>.
            </p>
        </header>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Please check the highlighted fields.</strong>
                {{ $errors->count() === 1 ? $errors->first() : 'Some details are missing or invalid.' }}
            </div>
        @endif

        <form method="POST" action="{{ route('setup.store') }}" enctype="multipart/form-data" class="card setup-card" novalidate>
            @csrf
            <div class="card-body">
                @include('setup._form')

                @if ($createAdmin)
                    <div class="org-section">
                        <div class="org-section-head">
                            <span class="org-step">4</span>
                            <div>
                                <h3>Administrator account</h3>
                                <p>No accounts exist yet. This person will manage the system and can add other users.</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="admin_name">Full name <span class="req">*</span></label>
                                <input id="admin_name" name="admin_name" class="form-control @error('admin_name') is-invalid @enderror" value="{{ old('admin_name') }}" required maxlength="255" autocomplete="name">
                                @error('admin_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="admin_phone">Phone number <span class="req">*</span></label>
                                <input id="admin_phone" name="admin_phone" class="form-control @error('admin_phone') is-invalid @enderror" value="{{ old('admin_phone') }}" required maxlength="20" autocomplete="tel">
                                @error('admin_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="admin_email">Email (used to sign in) <span class="req">*</span></label>
                            <input id="admin_email" type="email" name="admin_email" class="form-control @error('admin_email') is-invalid @enderror" value="{{ old('admin_email') }}" required maxlength="255" autocomplete="username">
                            @error('admin_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="admin_password">Password <span class="req">*</span></label>
                                <input id="admin_password" type="password" name="admin_password" class="form-control @error('admin_password') is-invalid @enderror" required minlength="8" autocomplete="new-password">
                                <small class="form-text">At least 8 characters.</small>
                                @error('admin_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="admin_password_confirmation">Confirm password <span class="req">*</span></label>
                                <input id="admin_password_confirmation" type="password" name="admin_password_confirmation" class="form-control" required minlength="8" autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer setup-actions">
                @auth
                    <span class="text-muted small">
                        Signed in as {{ Auth::user()->fullName }} ·
                        <button type="submit" form="logoutForm" class="btn btn-link btn-sm p-0 align-baseline">Sign out</button>
                    </span>
                @else
                    <span class="text-muted small">Fields marked <span class="req">*</span> are required.</span>
                @endauth
                <button type="submit" class="btn btn-primary btn-lg">
                    Save and start using the system <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </form>
        @auth
            <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>
        @endauth
    </main>
</body>
</html>
