<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::orderBy('role')->orderBy('name')->get();
        return view('superadmin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:superadmin,admin,user',
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function update(Request $request, \App\Models\User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:superadmin,admin,user',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->password) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function destroy(\App\Models\User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', "You cannot delete your own account.");
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
