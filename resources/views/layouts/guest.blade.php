<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sign in · BinAbba Logistics</title>
        <link rel="icon" href="{{ asset('images/binabbalogo.png') }}" type="image/png">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

        <!-- Tailwind build: still used by the Breeze password-reset components -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root { --brand: #13795b; --brand-700: #0b5640; --brand-50: #ecf6f2; --brand-100: #d3ebe1; --ink: #17212b; --ink-2: #4a5763; --muted: #8a96a1; --line: #e6eaee; }
            body { margin: 0; font-family: "Inter", -apple-system, "Segoe UI", Roboto, sans-serif; color: var(--ink-2); background: #f5f7f8; -webkit-font-smoothing: antialiased; }
            .auth { min-height: 100vh; display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(0, 1fr); }

            .auth-aside {
                position: relative; overflow: hidden;
                display: flex; flex-direction: column; justify-content: space-between;
                padding: 3rem 3.5rem;
                color: #e6f3ee;
                background:
                    radial-gradient(1200px 500px at -10% 110%, rgba(255,255,255,.08), transparent 60%),
                    radial-gradient(700px 400px at 110% -10%, rgba(255,255,255,.07), transparent 60%),
                    linear-gradient(160deg, #0f6a4f 0%, #0b4c39 55%, #083a2c 100%);
            }
            .auth-aside::after {
                content: ""; position: absolute; inset: 0; pointer-events: none;
                background-image: linear-gradient(rgba(255,255,255,.045) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.045) 1px, transparent 1px);
                background-size: 44px 44px;
                mask-image: linear-gradient(180deg, transparent, #000 30%, #000 70%, transparent);
                -webkit-mask-image: linear-gradient(180deg, transparent, #000 30%, #000 70%, transparent);
            }
            .auth-aside > * { position: relative; z-index: 1; }
            .auth-logo { display: inline-flex; align-items: center; gap: .75rem; text-decoration: none; }
            .auth-logo span.mark { background: #fff; border-radius: 12px; padding: .45rem .6rem; display: inline-flex; }
            .auth-logo img { height: 30px; display: block; }
            .auth-logo strong { color: #fff; font-size: 1.05rem; font-weight: 700; letter-spacing: .01em; }
            .auth-pitch h2 { color: #fff; font-size: 2.1rem; line-height: 1.2; font-weight: 700; letter-spacing: -.02em; margin: 0 0 1rem; max-width: 26rem; }
            .auth-pitch p { margin: 0; max-width: 26rem; line-height: 1.65; color: #bfe0d3; font-size: .95rem; }
            .auth-points { display: grid; gap: .85rem; margin-top: 2.25rem; padding: 0; list-style: none; }
            .auth-points li { display: flex; align-items: center; gap: .75rem; font-size: .9rem; color: #dcefe7; }
            .auth-points i { width: 2rem; height: 2rem; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; background: rgba(255,255,255,.1); color: #fff; font-size: .8rem; }
            .auth-aside small { color: #98c9b6; font-size: .78rem; }

            .auth-main { display: flex; align-items: center; justify-content: center; padding: 2.5rem 1.5rem; background: #fff; }
            .auth-card { width: 100%; max-width: 400px; }
            .auth-card .auth-mobile-logo { display: none; margin-bottom: 2rem; }
            .auth-card .auth-mobile-logo img { height: 40px; }
            .auth-card h1 { color: var(--ink); font-size: 1.6rem; font-weight: 700; letter-spacing: -.02em; margin: 0 0 .4rem; }
            .auth-card .lead { color: var(--muted); font-size: .92rem; margin: 0 0 2rem; }

            .auth-field { margin-bottom: 1.15rem; }
            .auth-field label { display: block; color: var(--ink); font-size: .83rem; font-weight: 500; margin-bottom: .45rem; }
            .auth-input { position: relative; }
            .auth-input i { position: absolute; left: .95rem; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: .85rem; pointer-events: none; }
            .auth-input input {
                width: 100%; box-sizing: border-box; height: 2.9rem; padding: 0 .95rem 0 2.6rem;
                border: 1px solid #d9dfe4; border-radius: 10px; background: #fff;
                font: inherit; font-size: .9rem; color: var(--ink); outline: none;
                transition: border-color .15s, box-shadow .15s;
            }
            .auth-input input:focus { border-color: var(--brand); box-shadow: 0 0 0 3px var(--brand-100); }
            .auth-input .toggle-pw { position: absolute; right: .5rem; top: 50%; transform: translateY(-50%); border: 0; background: none; color: var(--muted); cursor: pointer; padding: .4rem; border-radius: 6px; }
            .auth-input .toggle-pw:hover { color: var(--ink); }
            .auth-error { color: #c8423b; font-size: .78rem; margin-top: .4rem; }
            .auth-status { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); border-radius: 10px; padding: .75rem 1rem; font-size: .85rem; margin-bottom: 1.25rem; }

            .auth-row { display: flex; align-items: center; justify-content: space-between; margin: .25rem 0 1.5rem; font-size: .85rem; }
            .auth-row label { display: inline-flex; align-items: center; gap: .5rem; color: var(--ink-2); cursor: pointer; }
            .auth-row input[type="checkbox"] { width: 1rem; height: 1rem; accent-color: var(--brand); }
            .auth-row a, .auth-link { color: var(--brand); font-weight: 500; text-decoration: none; }
            .auth-row a:hover, .auth-link:hover { color: var(--brand-700); text-decoration: underline; }

            .auth-btn {
                width: 100%; height: 2.9rem; border: 0; border-radius: 10px; cursor: pointer;
                background: var(--brand); color: #fff; font: inherit; font-weight: 600; font-size: .92rem;
                display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
                transition: background .15s, box-shadow .15s;
            }
            .auth-btn:hover { background: var(--brand-700); }
            .auth-btn:focus-visible { outline: none; box-shadow: 0 0 0 3px var(--brand-100); }
            .auth-foot { margin-top: 2.5rem; color: var(--muted); font-size: .78rem; text-align: center; }

            /* Breeze components on the other auth pages */
            .auth-card input[type="email"], .auth-card input[type="password"], .auth-card input[type="text"] { border-radius: 10px; }
            .auth-card button[type="submit"]:not(.auth-btn) { background: var(--brand) !important; border-radius: 10px; }

            @media (max-width: 900px) {
                .auth { grid-template-columns: 1fr; }
                .auth-aside { display: none; }
                .auth-main { background: #f5f7f8; align-items: flex-start; padding-top: 4rem; }
                .auth-card { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 2rem 1.5rem; }
                .auth-card .auth-mobile-logo { display: block; }
            }
        </style>
    </head>
    <body>
        <div class="auth">
            <aside class="auth-aside">
                <a class="auth-logo" href="{{ url('/') }}">
                    <span class="mark"><img src="{{ asset('images/binabbalogo.png') }}" alt="BinAbba"></span>
                    <strong>BinAbba Logistics</strong>
                </a>

                <div class="auth-pitch">
                    <h2>Every truck, trip and naira in one place.</h2>
                    <p>Manage clients, goods, drivers, payments and expenses for Bin-Abba Nig. Ltd. from a single, simple workspace.</p>
                    <ul class="auth-points">
                        <li><i class="fas fa-truck"></i> Fleet, drivers and trip operations</li>
                        <li><i class="fas fa-money-bill-wave"></i> Payments, expenses and fuel debts</li>
                        <li><i class="fas fa-file-pdf"></i> Printable reports and invoices</li>
                    </ul>
                </div>

                <small>&copy; {{ date('Y') }} Bin-Abba Nig. Ltd.</small>
            </aside>

            <main class="auth-main">
                <div class="auth-card">
                    <div class="auth-mobile-logo">
                        <img src="{{ asset('images/binabbalogo.png') }}" alt="BinAbba">
                    </div>
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
