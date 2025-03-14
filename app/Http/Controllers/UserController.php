<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Get All Users
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Update User
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate request data
        $request->validate([
            'first_name' => 'required|string|max:255', 
            'last_name' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email,' . $id, 
            'password' => 'required|string|min:6|bcrypt',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'zipcode' => 'sometimes|string',
            'country' => 'sometimes|string',
        ]);


        // Update user data
        $user->update($request->all());

        return response()->json(['message' => 'User updated successfully!', 'user' => $user], 200);
    }

    // Delete User
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully!'], 200);
    }
}
