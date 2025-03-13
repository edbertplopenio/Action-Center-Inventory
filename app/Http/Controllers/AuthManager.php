<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthManager extends Controller
{
    // Show login form
    public function login()
    {
        return view('login');
    }

    // Show registration form
    public function registration()
    {
        return view('registration');
    }

   // Handle login request
public function loginPost(Request $request)
{
    // Validate login data using array format for regex rule
    $request->validate([
        'email'    => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/'],
        'password' => 'required'
    ]);

    // Attempt to log in with credentials
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Redirect to home page on successful login
        return redirect()->route('home')->with("status", "login_success");
    }

    // Redirect back with error if login fails
    return redirect()->route('login')->with("status", "login_error");
}


    // Handle registration request
    public function registrationPost(Request $request)
    {
        // Validate registration data using array format for regex rules
        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email' => ['required', 'regex:/^\d{2}-\d{5}@g\\.batstate-u\\.edu\\.ph$/', 'unique:users,email'], // Email regex rule in array format
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',  // Ensures password contains at least one uppercase letter
                'regex:/[0-9]/',  // Ensures password contains at least one number
                'regex:/[\W_]/',  // Ensures password contains at least one special character
            ],
            'department'     => 'nullable|string|max:255',
            'contact_number' => ['nullable', 'regex:/^(09|\+639)\d{9}$/'],  // Contact number regex rule in array format
        ]);

        // Create new user
        $user = User::create([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'department'     => $request->department,
            'contact_number' => $request->contact_number,
        ]);

        // Inside registrationPost method
        if (!$user) {
            return redirect()->route('registration')->with("status", "error");
        }

        // Use a unique status message for registration success
        return redirect()->route('login')->with("status", "registration_success");
    }

    // Handle logout request
    public function logout()
    {
        // Clear session and log out the user
        Session::flush();
        Auth::logout();

        // Redirect to login page after logout
        return redirect()->route('login');
    }
}
