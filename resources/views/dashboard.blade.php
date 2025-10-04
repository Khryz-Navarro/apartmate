<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Dashboard - {{ config('app.name', 'ApartMate') }}</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e1e5e9;
        }
        
        .dashboard-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .logout-button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .logout-button:hover {
            background: #c82333;
            transform: translateY(-1px);
        }
        
        .welcome-message {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .welcome-message h2 {
            margin-bottom: 10px;
            font-size: 24px;
        }
        
        .welcome-message p {
            opacity: 0.9;
            font-size: 16px;
        }
        
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            font-size: 32px;
            margin-bottom: 10px;
            color: #667eea;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 14px;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .action-button {
            background: white;
            border: 2px solid #e1e5e9;
            padding: 15px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .action-button:hover {
            border-color: #667eea;
            color: #667eea;
            transform: translateY(-2px);
        }
        
        .action-icon {
            font-size: 24px;
            margin-bottom: 8px;
            display: block;
        }
    </style>
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
                <div class="stat-number">1</div>
                <div class="stat-label">Active User</div>
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
            <a href="#" class="action-button">
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
