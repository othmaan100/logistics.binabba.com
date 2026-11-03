{{--
    Shared dashboard shell for the admin and staff (secretary) areas.
    Expects from the extending layout: $menu, $panelName, $homeUrl.
    Menu entries: ['heading' => '...'] or
    ['label', 'icon', 'url' | 'items' => [[label, url], ...], 'match' => [path patterns]]
--}}
@php
    $user = \Auth::user();
    $initials = collect(preg_split('/\s+/', trim($user->fullName ?? 'U')))
        ->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');

    $isActive = fn ($entry) => collect($entry['match'] ?? [])->contains(fn ($p) => request()->is($p));

    $pageTitle = 'Dashboard';
    foreach ($menu as $entry) {
        if (isset($entry['label']) && $isActive($entry)) {
            $pageTitle = $entry['label'];
            foreach ($entry['items'] ?? [] as [$subLabel, $subUrl]) {
                if (url()->current() === rtrim($subUrl, '/')) {
                    $pageTitle = $subLabel;
                }
            }
        }
    }
    $customTitle = trim($__env->yieldContent('title'));
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $customTitle ?: $pageTitle }} · BinAbba Logistics</title>
    <link rel="icon" href="{{ asset('images/binabbalogo.png') }}" type="image/png">

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    @yield("headers")
    <link href="{{ asset('css/theme.css') }}?v={{ filemtime(public_path('css/theme.css')) }}" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-light app-sidebar accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center" href="{{ $homeUrl }}">
                <img src="{{ asset('images/binabbalogo.png') }}" alt="BinAbba">
                <div class="brand-text">
                    <strong>BinAbba</strong>
                    <small>{{ $panelName }}</small>
                </div>
            </a>

            <hr class="sidebar-divider my-0 mb-2">

            @foreach ($menu as $i => $entry)
                @if (isset($entry['heading']))
                    <div class="sidebar-heading">{{ $entry['heading'] }}</div>
                @elseif (isset($entry['items']))
                    @php $open = $isActive($entry); @endphp
                    <li class="nav-item {{ $open ? 'active' : '' }}">
                        <a class="nav-link {{ $open ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
                            data-target="#menu{{ $i }}" aria-expanded="{{ $open ? 'true' : 'false' }}" aria-controls="menu{{ $i }}">
                            <i class="fas fa-fw {{ $entry['icon'] }}"></i>
                            <span>{{ $entry['label'] }}</span>
                        </a>
                        <div id="menu{{ $i }}" class="collapse {{ $open ? 'show' : '' }}" data-parent="#accordionSidebar">
                            <div class="collapse-inner">
                                @foreach ($entry['items'] as [$subLabel, $subUrl])
                                    <a class="collapse-item {{ url()->current() === rtrim($subUrl, '/') ? 'active' : '' }}"
                                        href="{{ $subUrl }}">{{ $subLabel }}</a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                @else
                    <li class="nav-item {{ $isActive($entry) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ $entry['url'] }}">
                            <i class="fas fa-fw {{ $entry['icon'] }}"></i>
                            <span>{{ $entry['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach

            <div class="text-center d-none d-md-inline mt-3 mb-3">
                <button class="rounded-circle border-0" id="sidebarToggle" aria-label="Collapse sidebar"></button>
            </div>

            <div class="sidebar-user">
                <span class="avatar">{{ $initials }}</span>
                <div class="who">
                    <strong class="text-capitalize">{{ strtolower($user->fullName) }}</strong>
                    <small>{{ $panelName }}</small>
                </div>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light topbar app-topbar static-top">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" aria-label="Open menu">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="page-heading">
                        <div class="crumbs">
                            <span>{{ $panelName }}</span><span>{{ $pageTitle }}</span>
                        </div>
                        <h1>{{ $customTitle ?: $pageTitle }}</h1>
                    </div>

                    <ul class="navbar-nav ml-auto align-items-center">
                        <li class="nav-item d-none d-lg-flex">
                            <span class="topbar-date"><i class="far fa-calendar mr-1"></i> {{ now()->format('l, j M Y') }}</span>
                        </li>

                        <div class="topbar-divider d-none d-lg-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="user-chip">
                                    <span class="who d-none d-md-block">
                                        <strong class="text-capitalize">{{ strtolower($user->fullName) }}</strong>
                                        <small>{{ $user->email }}</small>
                                    </span>
                                    <span class="avatar">{{ $initials }}</span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="userDropdown">
                                <h6 class="dropdown-header text-uppercase">Signed in as {{ $panelName }}</h6>
                                <a class="dropdown-item" href="{{ url('profile') }}"><i class="fas fa-user-circle fa-fw"></i> My profile</a>
                                @if (!empty($activityUrl))
                                    <a class="dropdown-item" href="{{ $activityUrl }}"><i class="fas fa-history fa-fw"></i> Activity log</a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-fw"></i> Log out
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <div class="container-fluid">
                    @yield("content")
                </div>

            </div>

            <footer class="sticky-footer app-footer">
                <div class="copyright d-flex flex-wrap justify-content-between">
                    <span>&copy; {{ date('Y') }} Bin-Abba Nig. Ltd. · Logistics Management</span>
                    <span>Developed by <strong>HORAIZON TECH</strong></span>
                </div>
            </footer>

        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top" aria-label="Back to top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Ready to leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">You will be signed out of your BinAbba session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i> Log out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script>
        // Start with the sidebar closed on phones; tap outside it to close again.
        (function ($) {
            var $sidebar = $('.app-sidebar');
            if (window.innerWidth < 768) { $('body').addClass('sidebar-toggled'); $sidebar.addClass('toggled'); }
            $('#content-wrapper').on('click', function (e) {
                if (window.innerWidth < 768 && !$sidebar.hasClass('toggled') && !$(e.target).closest('#sidebarToggleTop').length) {
                    $('body').addClass('sidebar-toggled'); $sidebar.addClass('toggled');
                }
            });
        })(jQuery);
    </script>

    @yield("footers")

</body>

</html>
