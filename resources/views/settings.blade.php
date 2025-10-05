<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Settings - {{ config('app.name', 'ApartMate') }}</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/all.min.css') }}">
    
</head>
<body>
    <div class="dashboard-container">
        <div class="settings-container">
            <a href="{{ route('dashboard') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to Dashboard
            </a>
            
            <h1 class="page-title">Settings</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Account Information Section -->
            <div class="settings-section">
                <h2><i class="fas fa-user"></i> Account Information</h2>
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" value="{{ Auth::user()->name }}" readonly>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="{{ Auth::user()->email }}" readonly>
                </div>
                
                <div class="form-group">
                    <label for="created_at">Member Since</label>
                    <input type="text" id="created_at" value="{{ Auth::user()->created_at->format('F j, Y') }}" readonly>
                </div>
            </div>
            
            <!-- Password Change Section -->
            <div class="settings-section">
                <h2><i class="fas fa-lock"></i> Change Password</h2>
                
                <form method="POST" action="{{ route('settings.change-password') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required 
                               class="@error('current_password') error @enderror"
                               value="{{ old('current_password') }}">
                        @error('current_password')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required minlength="8"
                               class="@error('new_password') error @enderror"
                               value="{{ old('new_password') }}">
                        <div class="password-requirements">
                            <small>Password must be at least 8 characters and contain:</small>
                            <ul id="password-requirements-list">
                                <li id="req-length" class="requirement-item">
                                    <i class="fas fa-times"></i> At least 8 characters
                                </li>
                                <li id="req-uppercase" class="requirement-item">
                                    <i class="fas fa-times"></i> One uppercase letter (A-Z)
                                </li>
                                <li id="req-lowercase" class="requirement-item">
                                    <i class="fas fa-times"></i> One lowercase letter (a-z)
                                </li>
                                <li id="req-number" class="requirement-item">
                                    <i class="fas fa-times"></i> One number (0-9)
                                </li>
                                <li id="req-special" class="requirement-item">
                                    <i class="fas fa-times"></i> One special character (@$!%*?&)
                                </li>
                            </ul>
                        </div>
                        @error('new_password')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required minlength="8"
                               class="@error('new_password_confirmation') error @enderror"
                               value="{{ old('new_password_confirmation') }}">
                        @error('new_password_confirmation')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Password
                    </button>
                </form>
            </div>
            
            <!-- Danger Zone -->
            <div class="settings-section danger-zone">
                <h2><i class="fas fa-exclamation-triangle"></i> Danger Zone</h2>
                
                @if(Auth::user()->delete_requested_at)
                    <div class="deletion-status">
                        <h3><i class="fas fa-clock"></i> Account Deletion Pending</h3>
                        <p>Your account deletion was requested on <strong>{{ Auth::user()->delete_requested_at->format('F j, Y \a\t g:i A') }}</strong>.</p>
                        <p>You have until <strong>{{ Auth::user()->delete_requested_at->addDays(7)->format('F j, Y \a\t g:i A') }}</strong> to recover your account.</p>
                        <p class="recovery-info">
                            <i class="fas fa-info-circle"></i> 
                            Check your email for recovery instructions, or use the button below to cancel the deletion.
                        </p>
                        
                        <form method="POST" action="{{ route('settings.cancel-deletion') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-undo"></i> Cancel Account Deletion
                            </button>
                        </form>
                    </div>
                @else
                    <h3>Delete Account</h3>
                    <p>Once you delete your account, you will have 7 days to recover it. After that, it will be permanently deleted.</p>
                    
                    <button type="button" class="btn btn-danger" onclick="showDeleteConfirmation()">
                        <i class="fas fa-trash"></i> Request Account Deletion
                    </button>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="confirmation-modal">
        <div class="modal-content">
            <h3><i class="fas fa-exclamation-triangle"></i> Request Account Deletion</h3>
            <p>Are you absolutely sure you want to request account deletion?</p>
            <p><strong>What happens next:</strong></p>
            <ul>
                <li>You will be logged out immediately</li>
                <li>Your account will be marked for deletion</li>
                <li>You have 7 days to recover your account</li>
                <li>After 7 days, your account will be permanently deleted</li>
            </ul>
            <p><strong>Recovery:</strong> Check your email for recovery instructions or contact support.</p>
            
            <div class="modal-buttons">
                <button type="button" class="btn btn-secondary" onclick="hideDeleteConfirmation()">
                    Cancel
                </button>
                <form method="POST" action="{{ route('settings.delete-account') }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Yes, Request Account Deletion
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function showDeleteConfirmation() {
            document.getElementById('deleteModal').style.display = 'block';
        }
        
        function hideDeleteConfirmation() {
            document.getElementById('deleteModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                hideDeleteConfirmation();
            }
        }

        // Password validation
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('new_password');
            const confirmInput = document.getElementById('new_password_confirmation');
            
            if (passwordInput) {
                passwordInput.addEventListener('input', validatePassword);
                confirmInput.addEventListener('input', validatePasswordConfirmation);
            }
        });

        function validatePassword() {
            const password = document.getElementById('new_password').value;
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /\d/.test(password),
                special: /[@$!%*?&]/.test(password)
            };

            // Update visual indicators
            updateRequirement('req-length', requirements.length);
            updateRequirement('req-uppercase', requirements.uppercase);
            updateRequirement('req-lowercase', requirements.lowercase);
            updateRequirement('req-number', requirements.number);
            updateRequirement('req-special', requirements.special);

            // Validate confirmation if it has a value
            if (document.getElementById('new_password_confirmation').value) {
                validatePasswordConfirmation();
            }
        }

        function validatePasswordConfirmation() {
            const password = document.getElementById('new_password').value;
            const confirmation = document.getElementById('new_password_confirmation').value;
            const confirmInput = document.getElementById('new_password_confirmation');
            
            if (confirmation && password !== confirmation) {
                confirmInput.setCustomValidity('Passwords do not match');
            } else {
                confirmInput.setCustomValidity('');
            }
        }

        function updateRequirement(elementId, isValid) {
            const element = document.getElementById(elementId);
            const icon = element.querySelector('i');
            
            if (isValid) {
                element.classList.add('requirement-met');
                element.classList.remove('requirement-not-met');
                icon.className = 'fas fa-check';
            } else {
                element.classList.add('requirement-not-met');
                element.classList.remove('requirement-met');
                icon.className = 'fas fa-times';
            }
        }
    </script>
</body>
</html>
