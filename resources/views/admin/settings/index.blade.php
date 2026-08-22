@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Site Settings',
        'description' => 'Configure your website content, integrations, and account.',
    ])

    <h2 class="h6 text-uppercase mb-3" style="color: var(--muted); letter-spacing: .1em;">Website content</h2>
    <div class="admin-tile-grid mb-4">
        <a class="admin-tile" href="{{ route('admin.settings.site-content') }}">
            <span class="admin-tile-icon"><i data-lucide="layout-template"></i></span>
            <span>
                <h2>Public Site Content</h2>
                <p>Global navigation, page copy, calls to action, and image paths.</p>
            </span>
        </a>
        <a class="admin-tile" href="{{ route('admin.settings.home') }}">
            <span class="admin-tile-icon"><i data-lucide="home"></i></span>
            <span>
                <h2>Home Page</h2>
                <p>Homepage title, description, statistics, and featured video.</p>
            </span>
        </a>
        <a class="admin-tile" href="{{ route('admin.settings.meta') }}">
            <span class="admin-tile-icon"><i data-lucide="badge-check"></i></span>
            <span>
                <h2>Brand &amp; SEO</h2>
                <p>Logo, meta tags, and search engine information.</p>
            </span>
        </a>
        <a class="admin-tile" href="{{ route('admin.settings.contact') }}">
            <span class="admin-tile-icon"><i data-lucide="phone"></i></span>
            <span>
                <h2>Contact Details</h2>
                <p>Phone, email, address, and map information.</p>
            </span>
        </a>
        <a class="admin-tile" href="{{ route('admin.settings.team') }}">
            <span class="admin-tile-icon"><i data-lucide="users"></i></span>
            <span>
                <h2>Team Page</h2>
                <p>Team page hero copy and section text.</p>
            </span>
        </a>
        <a class="admin-tile" href="{{ route('admin.settings.services') }}">
            <span class="admin-tile-icon"><i data-lucide="spray-can"></i></span>
            <span>
                <h2>Services Page</h2>
                <p>Service areas and promises shown on the Services page.</p>
            </span>
        </a>
        <a class="admin-tile" href="{{ route('admin.settings.about') }}">
            <span class="admin-tile-icon"><i data-lucide="book-open"></i></span>
            <span>
                <h2>About Page</h2>
                <p>Hero section, statistics, values, and company story.</p>
            </span>
        </a>
        <a class="admin-tile" href="{{ route('admin.settings.testimonials') }}">
            <span class="admin-tile-icon"><i data-lucide="message-square-quote"></i></span>
            <span>
                <h2>Testimonials Page</h2>
                <p>Page title, description, and call-to-action section.</p>
            </span>
        </a>
    </div>

    <h2 class="h6 text-uppercase mb-3" style="color: var(--muted); letter-spacing: .1em;">Integrations</h2>
    <div class="admin-tile-grid mb-4">
        <a class="admin-tile" href="{{ route('admin.settings.analytics') }}">
            <span class="admin-tile-icon"><i data-lucide="bar-chart-3"></i></span>
            <span>
                <h2>Google Analytics</h2>
                <p>Tracking, measurement ID, and data collection settings.</p>
            </span>
        </a>
        <a class="admin-tile" href="{{ route('admin.settings.googlemap') }}">
            <span class="admin-tile-icon"><i data-lucide="map-pin"></i></span>
            <span>
                <h2>Google Maps &amp; Reviews</h2>
                <p>Maps API key, default location, and review display options.</p>
            </span>
        </a>
    </div>

    <h2 class="h6 text-uppercase mb-3" style="color: var(--muted); letter-spacing: .1em;">Team operations</h2>
    <div class="admin-tile-grid mb-4">
        <a class="admin-tile" href="{{ route('admin.employees.index') }}">
            <span class="admin-tile-icon"><i data-lucide="id-card"></i></span>
            <span>
                <h2>Employees</h2>
                <p>Create employees, update codes, and manage password resets.</p>
            </span>
        </a>
        <a class="admin-tile" href="{{ route('admin.attendance.index') }}">
            <span class="admin-tile-icon"><i data-lucide="clock"></i></span>
            <span>
                <h2>Attendance Logs</h2>
                <p>Review punch history, filter by employee/date, export CSV.</p>
            </span>
        </a>
    </div>

    <h2 class="h6 text-uppercase mb-3" style="color: var(--muted); letter-spacing: .1em;">Security</h2>
    <div class="admin-tile-grid">
        <a class="admin-tile" href="{{ route('admin.settings.change-password') }}">
            <span class="admin-tile-icon"><i data-lucide="key-round"></i></span>
            <span>
                <h2>Change Password</h2>
                <p>Update your account password for better security.</p>
            </span>
        </a>
    </div>
@endsection
