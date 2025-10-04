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

// Reset button state function
function resetButtonState() {
    const button = document.getElementById('loginButton');
    const buttonText = document.getElementById('buttonText');
    
    button.classList.remove('loading');
    buttonText.textContent = 'Sign In';
    button.disabled = false;
}

// Set loading state function
function setLoadingState() {
    const button = document.getElementById('loginButton');
    const buttonText = document.getElementById('buttonText');
    
    button.classList.add('loading');
    buttonText.textContent = 'Signing In...';
    button.disabled = true;
}

// Email validation function
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus on email field if empty
    const emailField = document.getElementById('email');
    if (!emailField.value) {
        emailField.focus();
    }

    // Single form submission handler that combines validation and loading state
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Perform validation first
            if (!email || !password) {
                e.preventDefault();
                alert('Please fill in all fields');
                resetButtonState(); // Reset button state to allow retry
                return false;
            }
            
            if (!isValidEmail(email)) {
                e.preventDefault();
                alert('Please enter a valid email address');
                resetButtonState(); // Reset button state to allow retry
                return false;
            }
            
            // If validation passes, set loading state
            setLoadingState();
        });
    }
});
