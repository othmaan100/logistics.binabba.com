<x-guest-layout>
    <h1>Welcome back</h1>
    <p class="lead">Sign in to continue to your dashboard.</p>

    @if (session('status'))
        <div class="auth-status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="auth-field">
            <label for="email">Email address</label>
            <div class="auth-input">
                <i class="far fa-envelope"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                    required autofocus autocomplete="username">
            </div>
            @error('email')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password">Password</label>
            <div class="auth-input">
                <i class="fas fa-lock"></i>
                <input id="password" type="password" name="password" placeholder="Enter your password"
                    required autocomplete="current-password">
                <button type="button" class="toggle-pw" aria-label="Show password"
                    onclick="var p=document.getElementById('password'),s=p.type==='password';p.type=s?'text':'password';this.firstElementChild.className=s?'far fa-eye-slash':'far fa-eye';">
                    <i class="far fa-eye" style="position:static;transform:none"></i>
                </button>
            </div>
            @error('password')
                <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-row">
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember"> Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="auth-btn">
            Sign in <i class="fas fa-arrow-right" style="font-size:.8rem"></i>
        </button>
    </form>

    <p class="auth-foot">Need an account? Ask your administrator.</p>
</x-guest-layout>
