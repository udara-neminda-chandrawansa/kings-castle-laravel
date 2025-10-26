<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function update(Request $request)
    {
        $user = User::find(auth()->id());
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6'
        ]);

        // Sanitize
        $user->name = strip_tags(trim($validated['name']));
        $user->email = strip_tags(trim($validated['email']));

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return response()->json(['message' => 'Account updated successfully!']);
    }
}
