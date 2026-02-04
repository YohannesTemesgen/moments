<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        $auditLogs = AuditLog::with('user')->latest()->take(20)->get();
        return view('admin.users.index', compact('users', 'auditLogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'in:view-only,create,full'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'tenant_id' => tenant('id'),
        ]);

        AuditLog::log(
            'user_created',
            "Created new user: {$user->email} with role: {$user->role}",
            ['user_id' => $user->id, 'role' => $user->role]
        );

        return back()->with('success', 'User created successfully.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:view-only,create,full'],
        ]);

        $oldRole = $user->role;
        $user->update(['role' => $request->role]);

        AuditLog::log(
            'permission_modified',
            "Modified permissions for {$user->email}: from {$oldRole} to {$user->role}",
            ['target_user_id' => $user->id, 'old_role' => $oldRole, 'new_role' => $user->role]
        );

        return back()->with('success', 'User permissions updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot delete yourself.']);
        }

        $email = $user->email;
        $user->delete();

        AuditLog::log(
            'user_deleted',
            "Deleted user: {$email}",
            ['deleted_user_email' => $email]
        );

        return back()->with('success', 'User deleted successfully.');
    }
}
