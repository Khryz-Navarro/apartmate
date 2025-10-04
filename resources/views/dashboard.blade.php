<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Dashboard - {{ config('app.name', 'ApartMate') }}</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/all.min.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard</h1>
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-button">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="welcome-message">
            <h2>Welcome back, {{ Auth::user()->name }}!</h2>
            <p>You're successfully logged in to your ApartMate account.</p>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="stat-number">{{ $registeredUsersCount }}</div>
                <div class="stat-label">Registered User</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">Properties</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">Reviews</div>
            </div>
        </div>

        <div class="quick-actions">
            <a href="#" class="action-button">
                <i class="fas fa-plus action-icon"></i>
                Add Property
            </a>
            <a href="#" class="action-button">
                <i class="fas fa-search action-icon"></i>
                Browse Properties
            </a>
            <a href="{{ route('settings') }}" class="action-button">
                <i class="fas fa-cog action-icon"></i>
                Settings
            </a>
            <a href="#" class="action-button">
                <i class="fas fa-question-circle action-icon"></i>
                Help
            </a>
        </div>
    </div>
</body>
</html>
