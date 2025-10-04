// Login page JavaScript functionality

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

// Form submission with loading state
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const button = document.getElementById('loginButton');
    const buttonText = document.getElementById('buttonText');
    
    button.classList.add('loading');
    buttonText.textContent = 'Signing In...';
    button.disabled = true;
});

// Auto-focus on email field if empty
document.addEventListener('DOMContentLoaded', function() {
    const emailField = document.getElementById('email');
    if (!emailField.value) {
        emailField.focus();
    }
});

// Form validation
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    if (!email || !password) {
        e.preventDefault();
        alert('Please fill in all fields');
        return false;
    }
    
    if (!isValidEmail(email)) {
        e.preventDefault();
        alert('Please enter a valid email address');
        return false;
    }
});

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
