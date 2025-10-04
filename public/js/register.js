// Register page JavaScript functionality

// Password toggle functionality for main password field
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

// Password toggle functionality for confirmation password field
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

// Reset button state function
function resetButtonState() {
    const button = document.getElementById('registerButton');
    const buttonText = document.getElementById('buttonText');
    
    button.classList.remove('loading');
    buttonText.textContent = 'Create Account';
    button.disabled = false;
}

// Set loading state function
function setLoadingState() {
    const button = document.getElementById('registerButton');
    const buttonText = document.getElementById('buttonText');
    
    button.classList.add('loading');
    buttonText.textContent = 'Creating Account...';
    button.disabled = true;
}

// Email validation function
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Password strength validation
function validatePassword(password) {
    if (password.length < 6) {
        return 'Password must be at least 6 characters long';
    }
    return null;
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus on name field if empty
    const nameField = document.getElementById('name');
    if (nameField && !nameField.value) {
        nameField.focus();
    }

    // Single form submission handler that combines validation and loading state
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            
            // Perform validation first
            if (!name || !email || !password || !passwordConfirmation) {
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

            const passwordError = validatePassword(password);
            if (passwordError) {
                e.preventDefault();
                alert(passwordError);
                resetButtonState(); // Reset button state to allow retry
                return false;
            }

            if (password !== passwordConfirmation) {
                e.preventDefault();
                alert('Passwords do not match');
                resetButtonState(); // Reset button state to allow retry
                return false;
            }
            
            // If validation passes, set loading state
            setLoadingState();
        });
    }
});
