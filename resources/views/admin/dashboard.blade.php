<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Admin Dashboard - {{ config('app.name', 'ApartMate') }}</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/all.min.css') }}">
    
    <!-- Google Fonts (Local) -->
    <link rel="stylesheet" href="{{ asset('fonts/google/inter.css') }}">
</head>
<body class="admin-body">
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="fas fa-home"></i>
                    <span class="logo-text">ApartMate</span>
                </div>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" data-section="overview">
                            <i class="fas fa-tachometer-alt"></i>
                            <span class="nav-text">Overview</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="users">
                            <i class="fas fa-users"></i>
                            <span class="nav-text">Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="properties">
                            <i class="fas fa-building"></i>
                            <span class="nav-text">Properties</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="bookings">
                            <i class="fas fa-calendar-check"></i>
                            <span class="nav-text">Bookings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="payments">
                            <i class="fas fa-credit-card"></i>
                            <span class="nav-text">Payments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="reports">
                            <i class="fas fa-chart-bar"></i>
                            <span class="nav-text">Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-section="settings">
                            <i class="fas fa-cog"></i>
                            <span class="nav-text">Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ Auth::user()->name ?? 'Admin User' }}</span>
                        <span class="user-role">Administrator</span>
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="header-left">
                    <button class="mobile-sidebar-toggle" id="mobileSidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title" id="pageTitle">Dashboard Overview</h1>
                </div>
                
                <div class="header-right">
                    <div class="header-actions">
                        <button class="action-btn" title="Notifications">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <button class="action-btn" title="Messages">
                            <i class="fas fa-envelope"></i>
                        </button>
                        <button class="action-btn" title="Search">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Overview Section -->
                <div class="content-section active" id="overview">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h3>Total Users</h3>
                                <p class="stat-number">1,234</p>
                                <span class="stat-change positive">+12% this month</span>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="stat-content">
                                <h3>Properties</h3>
                                <p class="stat-number">456</p>
                                <span class="stat-change positive">+8% this month</span>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="stat-content">
                                <h3>Bookings</h3>
                                <p class="stat-number">789</p>
                                <span class="stat-change positive">+15% this month</span>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stat-content">
                                <h3>Revenue</h3>
                                <p class="stat-number">$45,678</p>
                                <span class="stat-change positive">+23% this month</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="dashboard-content">
                        <div class="content-row">
                            <div class="content-card">
                                <div class="card-header">
                                    <h3>Recent Activity</h3>
                                    <a href="#" class="view-all">View All</a>
                                </div>
                                <div class="card-content">
                                    <div class="activity-list">
                                        <div class="activity-item">
                                            <div class="activity-icon">
                                                <i class="fas fa-user-plus"></i>
                                            </div>
                                            <div class="activity-content">
                                                <p><strong>New user registered</strong></p>
                                                <span class="activity-time">2 minutes ago</span>
                                            </div>
                                        </div>
                                        <div class="activity-item">
                                            <div class="activity-icon">
                                                <i class="fas fa-calendar-plus"></i>
                                            </div>
                                            <div class="activity-content">
                                                <p><strong>New booking created</strong></p>
                                                <span class="activity-time">15 minutes ago</span>
                                            </div>
                                        </div>
                                        <div class="activity-item">
                                            <div class="activity-icon">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div class="activity-content">
                                                <p><strong>Property added</strong></p>
                                                <span class="activity-time">1 hour ago</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="content-card">
                                <div class="card-header">
                                    <h3>Quick Actions</h3>
                                </div>
                                <div class="card-content">
                                    <div class="quick-actions">
                                        <button class="quick-action-btn">
                                            <i class="fas fa-plus"></i>
                                            <span>Add Property</span>
                                        </button>
                                        <button class="quick-action-btn">
                                            <i class="fas fa-user-plus"></i>
                                            <span>Add User</span>
                                        </button>
                                        <button class="quick-action-btn">
                                            <i class="fas fa-file-export"></i>
                                            <span>Export Data</span>
                                        </button>
                                        <button class="quick-action-btn">
                                            <i class="fas fa-cog"></i>
                                            <span>Settings</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Section -->
                <div class="content-section" id="users">
                    <div class="section-header">
                        <h2>User Management</h2>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Add New User
                        </button>
                    </div>
                    <div class="content-card">
                        <div class="card-content">
                            <p>User management content will go here...</p>
                        </div>
                    </div>
                </div>

                <!-- Properties Section -->
                <div class="content-section" id="properties">
                    <div class="section-header">
                        <h2>Property Management</h2>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Add New Property
                        </button>
                    </div>
                    <div class="content-card">
                        <div class="card-content">
                            <p>Property management content will go here...</p>
                        </div>
                    </div>
                </div>

                <!-- Bookings Section -->
                <div class="content-section" id="bookings">
                    <div class="section-header">
                        <h2>Booking Management</h2>
                    </div>
                    <div class="content-card">
                        <div class="card-content">
                            <p>Booking management content will go here...</p>
                        </div>
                    </div>
                </div>

                <!-- Payments Section -->
                <div class="content-section" id="payments">
                    <div class="section-header">
                        <h2>Payment Management</h2>
                    </div>
                    <div class="content-card">
                        <div class="card-content">
                            <p>Payment management content will go here...</p>
                        </div>
                    </div>
                </div>

                <!-- Reports Section -->
                <div class="content-section" id="reports">
                    <div class="section-header">
                        <h2>Reports & Analytics</h2>
                    </div>
                    <div class="content-card">
                        <div class="card-content">
                            <p>Reports and analytics content will go here...</p>
                        </div>
                    </div>
                </div>

                <!-- Settings Section -->
                <div class="content-section" id="settings">
                    <div class="section-header">
                        <h2>System Settings</h2>
                    </div>
                    <div class="content-card">
                        <div class="card-content">
                            <p>System settings content will go here...</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        // Sidebar functionality
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const navLinks = document.querySelectorAll('.nav-link');
        const contentSections = document.querySelectorAll('.content-section');
        const pageTitle = document.getElementById('pageTitle');

        // Desktop sidebar toggle
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // Mobile sidebar toggle
        mobileSidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('mobile-open');
        });

        // Navigation functionality
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove active class from all links
                navLinks.forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                link.classList.add('active');
                
                // Get section name
                const sectionName = link.getAttribute('data-section');
                
                // Hide all content sections
                contentSections.forEach(section => {
                    section.classList.remove('active');
                });
                
                // Show selected section
                const targetSection = document.getElementById(sectionName);
                if (targetSection) {
                    targetSection.classList.add('active');
                }
                
                // Update page title
                const linkText = link.querySelector('.nav-text').textContent;
                pageTitle.textContent = linkText;
                
                // Close mobile sidebar if open
                sidebar.classList.remove('mobile-open');
            });
        });

        // Close mobile sidebar when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !mobileSidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('mobile-open');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('mobile-open');
            }
        });
    </script>
    
    <!-- Dark Mode JavaScript -->
    <script src="{{ asset('js/dark-mode.js') }}"></script>
</body>
</html>
