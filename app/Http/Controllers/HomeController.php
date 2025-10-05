<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            // Permanently delete the account
            $user->deleteAccount();
            
            // Logout user immediately for security
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Store success message before redirecting
            return redirect()->route('home')->with('success', 'Your account has been permanently deleted.');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Account deletion failed: ' . $e->getMessage());
            
            return redirect()->route('settings')->with('error', 'Failed to delete account. Please try again or contact support.');
        }
    }

}
