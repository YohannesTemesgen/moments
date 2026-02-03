<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        $totalUsers = User::count();
        return view('superadmin.dashboard', compact('users', 'totalUsers'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('superadmin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('superadmin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('superadmin.users.index')->with('success', 'User created successfully.');
    }

    public function editUser(User $user)
    {
        return view('superadmin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        return redirect()->route('superadmin.users.index')->with('success', 'User updated successfully.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('superadmin.users.index')->with('success', 'User deleted successfully.');
    }

    public function profile()
    {
        $superadmin = Auth::guard('superadmin')->user();
        return view('superadmin.profile', compact('superadmin'));
    }

    public function updateProfile(Request $request)
    {
        $superadmin = Auth::guard('superadmin')->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:super_admins,email,' . $superadmin->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $superadmin->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $superadmin = Auth::guard('superadmin')->user();

        if (!Hash::check($request->current_password, $superadmin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $superadmin->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function settings()
    {
        $user = Auth::guard('superadmin')->user();
        return view('superadmin.settings', compact('user'));
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
