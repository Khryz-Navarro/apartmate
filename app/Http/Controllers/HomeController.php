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
        $registeredUsersCount = User::count();
        
        return view('dashboard', compact('registeredUsersCount'));
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
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
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
        
        // Log out the user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Delete the user account
        $user->delete();
        
        return redirect()->route('home')->with('success', 'Your account has been successfully deleted.');
    }
}
