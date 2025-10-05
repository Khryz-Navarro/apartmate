<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Notifications\AccountDeletionNotification;

class HomeController extends Controller
{
    /**
     * Show the landing page
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the dashboard with statistics
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Check if the user's account deletion has expired
        if ($user->hasExpiredDeletion()) {
            // Actually delete the account since grace period has expired
            try {
                $user->permanentDelete();
                \Log::info("Permanently deleted expired account during dashboard access: {$user->email}");
            } catch (\Exception $e) {
                \Log::error("Failed to delete expired account during dashboard access: " . $e->getMessage());
            }
            
            // Logout and redirect
            Auth::logout();
            return redirect()->route('home')->with('error', 'Your account has been permanently deleted due to expired deletion request.');
        }
        
        // Get user-specific statistics
        $userPropertiesCount = 0; // Placeholder for future property functionality
        $userBookingsCount = 0;   // Placeholder for future booking functionality
        $userReviewsCount = 0;    // Placeholder for future review functionality
        
        return view('dashboard', compact('userPropertiesCount', 'userBookingsCount', 'userReviewsCount'));
    }

    /**
     * Show the settings page
     */
    public function settings()
    {
        $user = Auth::user();
        
        // Check if the user's account deletion has expired
        if ($user->hasExpiredDeletion()) {
            // Actually delete the account since grace period has expired
            try {
                $user->permanentDelete();
                \Log::info("Permanently deleted expired account during settings access: {$user->email}");
            } catch (\Exception $e) {
                \Log::error("Failed to delete expired account during settings access: " . $e->getMessage());
            }
            
            // Logout and redirect
            Auth::logout();
            return redirect()->route('home')->with('error', 'Your account has been permanently deleted due to expired deletion request.');
        }
        
        return view('settings');
    }

    /**
     * Handle password change request
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            ],
        ], [
            'current_password.required' => 'Please enter your current password.',
            'new_password.required' => 'Please enter a new password.',
            'new_password.min' => 'The new password must be at least 8 characters long.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
            'new_password.regex' => 'The new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Check if new password is different from current password
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'The new password must be different from your current password.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('settings')->with('success', 'Password updated successfully!');
    }

    /**
     * Handle account deletion request
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        try {
            // Request account deletion with grace period
            $token = $user->requestDeletion();
            
            // Send email notification with recovery link
            try {
                $user->notify(new AccountDeletionNotification($user, $token));
            } catch (\Exception $emailException) {
                // Log the email error but don't fail the deletion request
                \Log::error('Failed to send account deletion email: ' . $emailException->getMessage());
            }
            
            // Logout user immediately for security
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Store success message before redirecting
            return redirect()->route('home')->with('success', 'Your account deletion has been requested. You have 7 days to recover your account. Check your email for recovery instructions.');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Account deletion failed: ' . $e->getMessage());
            
            // Return appropriate error message
            $errorMessage = 'Failed to request account deletion. ';
            if (str_contains($e->getMessage(), 'already pending')) {
                $errorMessage = 'Account deletion is already pending. Check your email for recovery instructions.';
            } else {
                $errorMessage .= 'Please try again or contact support.';
            }
            
            return redirect()->route('settings')->with('error', $errorMessage);
        }
    }

    /**
     * Cancel account deletion request
     */
    public function cancelAccountDeletion(Request $request)
    {
        $user = Auth::user();
        
        try {
            $user->cancelDeletion();
            return redirect()->route('settings')->with('success', 'Account deletion has been cancelled. Your account is safe.');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Account deletion cancellation failed: ' . $e->getMessage());
            
            // Return appropriate error message
            $errorMessage = 'Failed to cancel account deletion. ';
            if (str_contains($e->getMessage(), 'No pending')) {
                $errorMessage = 'No pending account deletion found.';
            } else {
                $errorMessage .= 'Please try again or contact support.';
            }
            
            return redirect()->route('settings')->with('error', $errorMessage);
        }
    }

    /**
     * Recover account using token
     */
    public function recoverAccount(Request $request, string $token)
    {
        try {
            // First, process any expired deletions to clean up old data
            User::processExpiredDeletions();

            $user = User::where('delete_token', $token)
                       ->whereNotNull('delete_requested_at')
                       ->first();

            if (!$user) {
                return redirect()->route('home')->with('error', 'Invalid or expired recovery token.');
            }

            // Validate the token matches exactly
            if (!$user->validateDeleteToken($token)) {
                return redirect()->route('home')->with('error', 'Invalid recovery token.');
            }

            // Check if the deletion has expired
            if ($user->hasExpiredDeletion()) {
                // Actually delete the account since grace period has expired
                try {
                    $user->permanentDelete();
                    \Log::info("Permanently deleted expired account during recovery attempt: {$user->email}");
                } catch (\Exception $deleteException) {
                    \Log::error("Failed to delete expired account during recovery: " . $deleteException->getMessage());
                }
                
                return redirect()->route('home')->with('error', 'Recovery period has expired. Your account has been permanently deleted.');
            }

            // Account is still within grace period, allow recovery
            $user->cancelDeletion();
            return redirect()->route('login')->with('success', 'Your account has been recovered successfully. You can now log in again.');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Account recovery failed: ' . $e->getMessage());
            
            return redirect()->route('home')->with('error', 'Failed to recover account. Please contact support.');
        }
    }
}
