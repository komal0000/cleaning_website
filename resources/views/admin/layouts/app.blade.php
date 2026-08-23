<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — Cleanway</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (legacy pages) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Dropify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/css/dropify.min.css">
    <!-- Cleanway admin design system -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    @stack('styles')

    @if(config('analytics.enabled') && config('analytics.measurement_id') && in_array(app()->environment(), config('analytics.environments', [])))
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('analytics.measurement_id') }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '{{ config('analytics.measurement_id') }}', {
        @if(config('analytics.anonymize_ip'))
        'anonymize_ip': true,
        @endif
        @if(config('analytics.debug_mode'))
        'debug_mode': true,
        @endif
        @if(!config('analytics.send_page_view'))
        'send_page_view': false,
        @endif
      });
    </script>
    <!-- End Google Analytics -->
    @endif
</head>
<body>

    <div class="admin-shell">
        <div class="admin-sidebar-backdrop" id="adminSidebarBackdrop"></div>

        <aside class="admin-sidebar" id="adminSidebar">
            <a class="admin-brand" href="{{ route('admin.settings.index') }}">
                <span class="admin-brand-mark"><i data-lucide="sparkles"></i></span>
                <span>Cleanway Admin</span>
            </a>

            <nav class="admin-nav">
                @if(Auth::user() && Auth::user()->isSuperAdmin())
                <div class="admin-nav-group">Content</div>
                <a class="admin-nav-link {{ request()->routeIs('teams.*') ? 'active' : '' }}" href="{{ route('teams.index') }}"><i data-lucide="users"></i>Teams</a>
                <a class="admin-nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}"><i data-lucide="spray-can"></i>Services</a>
                <a class="admin-nav-link {{ request()->routeIs('careers.*') ? 'active' : '' }}" href="{{ route('careers.index') }}"><i data-lucide="briefcase"></i>Careers</a>
                <a class="admin-nav-link {{ request()->routeIs('testimonials.*') ? 'active' : '' }}" href="{{ route('testimonials.index') }}"><i data-lucide="star"></i>Testimonials</a>
                <a class="admin-nav-link {{ request()->routeIs('galleries.*') ? 'active' : '' }}" href="{{ route('galleries.index') }}"><i data-lucide="image"></i>Gallery</a>
                @endif

                <div class="admin-nav-group">Inbox</div>
                <a class="admin-nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}" href="{{ route('admin.contact-messages.index') }}"><i data-lucide="mail"></i>Contact Messages</a>
                <a class="admin-nav-link {{ request()->routeIs('admin.career-applications.*') ? 'active' : '' }}" href="{{ route('admin.career-applications.index') }}"><i data-lucide="file-text"></i>Applications</a>

                @if(Auth::user() && Auth::user()->isSuperAdmin())
                <div class="admin-nav-group">Manage</div>
                <a class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i data-lucide="user-cog"></i>Users</a>
                <a class="admin-nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" href="{{ route('admin.employees.index') }}"><i data-lucide="id-card"></i>Employees</a>
                <a class="admin-nav-link {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}" href="{{ route('admin.attendance.index') }}"><i data-lucide="clock"></i>Attendance</a>

                <div class="admin-nav-group">System</div>
                <a class="admin-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}"><i data-lucide="settings"></i>Settings</a>
                @endif
            </nav>

            <div class="admin-sidebar-footer">
                &copy; {{ date('Y') }} Cleanway Service Limited
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <button class="admin-sidebar-toggle" type="button" id="adminSidebarToggle" aria-label="Toggle navigation">
                    <i data-lucide="menu"></i>
                </button>
                <h1 class="admin-topbar-title">@yield('page-title', 'Dashboard')</h1>

                <div class="admin-topbar-user dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="admin-avatar">{{ collect(explode(' ', Auth::user()->name ?? 'A'))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('') }}</span>
                        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="{{ route('admin.settings.change-password') }}" class="dropdown-item">
                                <i class="fa-solid fa-key me-2"></i>Change Password
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </header>

            <main class="admin-content">
                @includeIf('admin.partials.flash')
                @yield('content')
            </main>

            <footer class="admin-footer">
                Cleanway Admin Panel
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- jQuery (required for Dropify) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Dropify JS -->
    <script src="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/js/dropify.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.dropify').dropify();
        });

        lucide.createIcons();

        const adminSidebar = document.getElementById('adminSidebar');
        const adminSidebarBackdrop = document.getElementById('adminSidebarBackdrop');
        document.getElementById('adminSidebarToggle').addEventListener('click', function () {
            adminSidebar.classList.toggle('show');
            adminSidebarBackdrop.classList.toggle('show');
        });
        adminSidebarBackdrop.addEventListener('click', function () {
            adminSidebar.classList.remove('show');
            adminSidebarBackdrop.classList.remove('show');
        });
    </script>
    @yield('script')
    @stack('scripts')

</body>
</html>
