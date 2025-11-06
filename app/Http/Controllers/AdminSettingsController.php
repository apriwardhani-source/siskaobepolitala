<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminSettingsController extends Controller
{
    /**
     * Display settings dashboard
     */
    public function index()
    {
        return view('admin.settings.index');
    }
    
    /**
     * Display WhatsApp settings (redirect to existing page)
     */
    public function whatsapp()
    {
        return redirect()->route('admin.whatsapp.connect');
    }
    
    /**
     * Display profile settings
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.settings.profile', compact('user'));
    }
    
    /**
     * Update profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.settings.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }
    
    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        
        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->route('admin.settings.profile')
            ->with('success', 'Password berhasil diubah!');
    }
    
    /**
     * Display system settings
     */
    public function system()
    {
        return view('admin.settings.system');
    }
}
