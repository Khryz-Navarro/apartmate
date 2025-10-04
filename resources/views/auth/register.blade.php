<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Register - {{ config('app.name', 'ApartMate') }}</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1 class="login-title">Create Account</h1>
            <p class="login-subtitle">Join us today</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf
            
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input" 
                    placeholder="Enter your full name"
                    value="{{ old('name') }}"
                    required 
                    autocomplete="name"
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    placeholder="Enter your email"
                    value="{{ old('email') }}"
                    required 
                    autocomplete="email"
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Create a password"
                        required 
                        autocomplete="new-password"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="passwordToggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-input" 
                        placeholder="Confirm your password"
                        required 
                        autocomplete="new-password"
                    >
                    <button type="button" class="password-toggle" onclick="togglePasswordConfirmation()">
                        <i class="fas fa-eye" id="passwordConfirmationToggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="login-button" id="registerButton">
                <span id="buttonText">Create Account</span>
            </button>
        </form>

        <div class="divider">
            <span>Already have an account?</span>
        </div>

        <div class="register-link">
            <a href="{{ route('login') }}">Sign in here</a>
        </div>
    </div>

    <script>
        // Password toggle functionality
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function togglePasswordConfirmation() {
            const passwordInput = document.getElementById('password_confirmation');
            const toggleIcon = document.getElementById('passwordConfirmationToggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Form submission with loading state
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const button = document.getElementById('registerButton');
            const buttonText = document.getElementById('buttonText');
            
            button.classList.add('loading');
            buttonText.textContent = 'Creating Account...';
            button.disabled = true;
        });

        // Auto-focus on name field if empty
        document.addEventListener('DOMContentLoaded', function() {
            const nameField = document.getElementById('name');
            if (!nameField.value) {
                nameField.focus();
            }
        });

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            
            if (!name || !email || !password || !passwordConfirmation) {
                e.preventDefault();
                alert('Please fill in all fields');
                return false;
            }
            
            if (!isValidEmail(email)) {
                e.preventDefault();
                alert('Please enter a valid email address');
                return false;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long');
                return false;
            }

            if (password !== passwordConfirmation) {
                e.preventDefault();
                alert('Passwords do not match');
                return false;
            }
        });

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>
</body>
</html>
