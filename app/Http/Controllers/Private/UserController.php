<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // List all users
        return view('private.users.index', compact('users'));
    }

    public function create()
    {
        return view('private.users.create'); // Form to create a new user
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:sales,purchasing,warehouse,route',
        ]);

        $userData = $request->all();
        $userData['password'] = bcrypt($request->password);
        
        $user = User::create($userData);

        return redirect()->route('private.users.index');
    }

    public function edit(User $user)
    {
        return view('private.users.edit', compact('user')); // Form to edit user details
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|in:sales,purchasing,warehouse,route',
        ]);

        $userData = $request->except('password');
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6'
            ]);
            $userData['password'] = bcrypt($request->password);
        }

        $user->update($userData);

        return redirect()->route('private.users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('private.users.index');
    }

    // New profile method to show user details
    public function profile(User $user)
    {
        return view('private.users.profile', compact('user')); // Display user profile
    }
}
