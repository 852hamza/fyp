<?php

namespace App\Http\Controllers;

use App\User;  // Ensure this is pointing to the correct User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;  // Import Log facade

class UserController extends Controller
{
    // Display edit user form
    public function editUser(User $user)
    {
        Log::info('Loading user edit form for user: ' . $user->id);
        return view('admin.edit', compact('user'));
    }

    // Update user
    public function updateUser(Request $request, User $user)
    {
        Log::info('Updating user: ' . $user->id);
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully!');
    }

    // Delete user
    public function deleteUser(User $user)
    {
        Log::info('Deleting user: ' . $user->id);
        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }
}
