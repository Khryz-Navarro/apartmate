<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'ApartMate') }} - Find Your Perfect Home</title>
    <meta name="description" content="Discover and book the perfect apartment for your next stay. ApartMate connects you with amazing properties worldwide.">
    
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/all.min.css') }}">
    
    <!-- Google Fonts (Local) -->
    <link rel="stylesheet" href="{{ asset('fonts/google/inter.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <nav class="nav-container">
            <a href="#" class="logo">ApartMate</a>
            
            <ul class="nav-menu" id="navMenu">
                <li><a href="#home" class="nav-link">Home</a></li>
                <li><a href="#features" class="nav-link">Features</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
            </ul>
            
            <div class="auth-buttons">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Admin Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                @endauth
            </div>
            
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Find Your Perfect Home</h1>
                <p>Discover amazing apartments and properties worldwide. Book your next stay with confidence through our trusted platform.</p>
                <div class="hero-buttons">
                    @auth
                        <a href="#properties" class="btn btn-primary">Explore Properties</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                        <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
                    @endauth
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/apartment-hero.jpg') }}" alt="Beautiful apartment interior" />
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose ApartMate?</h2>
                <p>We make finding and booking your perfect home simple, secure, and enjoyable.</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Smart Search</h3>
                    <p>Find properties that match your exact needs with our advanced filtering and search capabilities.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Secure Booking</h3>
                    <p>Book with confidence knowing your payments and personal information are protected with bank-level security.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>Verified Reviews</h3>
                    <p>Read authentic reviews from real guests to make informed decisions about your stay.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile Friendly</h3>
                    <p>Access your account and book properties on any device with our responsive mobile app.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Get help whenever you need it with our round-the-clock customer support team.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Global Coverage</h3>
                    <p>Discover properties in cities worldwide, from cozy apartments to luxury penthouses.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="about">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Find Your Perfect Home?</h2>
                <p>Join thousands of satisfied users who have found their ideal properties through ApartMate. Start your journey today!</p>
                @auth
                    <a href="#properties" class="btn btn-primary">Explore Properties</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">Create Account</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>ApartMate</h3>
                    <p>Connecting people with their perfect homes worldwide. Your trusted partner in property discovery and booking.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <p><a href="#home">Home</a></p>
                    <p><a href="#features">Features</a></p>
                    <p><a href="#about">About</a></p>
                    <p><a href="#contact">Contact</a></p>
                </div>
                
                <div class="footer-section">
                    <h3>Support</h3>
                    <p><a href="#">Help Center</a></p>
                    <p><a href="#">Privacy Policy</a></p>
                    <p><a href="#">Terms of Service</a></p>
                    <p><a href="#">Contact Us</a></p>
                </div>
                
                <div class="footer-section">
                    <h3>Connect</h3>
                    <p><a href="#"><i class="fab fa-facebook"></i> Facebook</a></p>
                    <p><a href="#"><i class="fab fa-twitter"></i> Twitter</a></p>
                    <p><a href="#"><i class="fab fa-instagram"></i> Instagram</a></p>
                    <p><a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a></p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} ApartMate. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const navMenu = document.getElementById('navMenu');
        
        mobileMenuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });

        // Header scroll effect
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
            });
        });

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe feature cards for animation
        document.querySelectorAll('.feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
    
    <!-- Dark Mode JavaScript -->
    <script src="{{ asset('js/dark-mode.js') }}"></script>
</body>
</html>
