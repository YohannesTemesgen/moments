<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.settings', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];

        // Add password validation rules if password is provided
        if ($request->filled('password')) {
            $rules['current_password'] = 'required';
            $rules['password'] = 'required|min:8|confirmed';
        }

        $request->validate($rules);

        // Update basic profile info
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Handle password update if provided
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateSetting(Request $request)
    {
        // Handle getting countdown date
        if ($request->input('action') === 'get_countdown_date') {
            $countdownDate = Setting::get('countdown_target_date', '2026-12-31 23:59:59');
            return response()->json(['countdown_date' => $countdownDate]);
        }
        
        // Handle setting update
        Setting::set($request->key, $request->value);
        return response()->json(['success' => true]);
    }
}
