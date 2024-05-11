<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $users = User::get();
        return view('user', [
            'users' => $users
        ]);
    }

    function create()
    {
        return view('create-user');
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8',
            'foto_url' => 'required|url', // Sesuaikan dengan kebutuhan Anda
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto_url' => $request->foto_url,
        ];

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('public/foto');
            $userData['foto'] = basename($fotoPath);
        }


        // UserController.php

        User::create($userData);

        return redirect()->action('App\Http\Controllers\UserController@index')->with('success', 'User created successfully!');
    }

    
    function destroy($id)
    {
        $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully.');
}


function edit($id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    return view('edit-user', ['user' => $user]);
}

public function update(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:8', // You can make the password optional
        'foto_url' => 'required|url', 
    ]);

    // Find the user by ID
    $user = User::find($id);

    // Check if the user exists
    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    // Update user information
    $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update profile picture URL if provided
        $user->foto_url = $request->foto_url;

        // Save the updated user information
        $user->save();

        // Redirect back with success message
        return redirect()->action('App\Http\Controllers\UserController@index')->with('success', 'User updated successfully!');
    }
}
