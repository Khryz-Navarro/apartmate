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
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required minlength="6">
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required minlength="6">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Password
                    </button>
                </form>
            </div>
            
            <!-- Danger Zone -->
            <div class="settings-section danger-zone">
                <h2><i class="fas fa-exclamation-triangle"></i> Danger Zone</h2>
                
                <h3>Delete Account</h3>
                <p>Once you delete your account, there is no going back. Please be certain.</p>
                
                <button type="button" class="btn btn-danger" onclick="showDeleteConfirmation()">
                    <i class="fas fa-trash"></i> Delete Account
                </button>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="confirmation-modal">
        <div class="modal-content">
            <h3><i class="fas fa-exclamation-triangle"></i> Delete Account</h3>
            <p>Are you absolutely sure you want to delete your account? This action cannot be undone.</p>
            <p><strong>This will permanently delete:</strong></p>
            <ul>
                <li>Your account and profile</li>
                <li>All your data</li>
                <li>Your login access</li>
            </ul>
            
            <div class="modal-buttons">
                <button type="button" class="btn btn-secondary" onclick="hideDeleteConfirmation()">
                    Cancel
                </button>
                <form method="POST" action="{{ route('settings.delete-account') }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Yes, Delete My Account
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
    </script>
</body>
</html>
