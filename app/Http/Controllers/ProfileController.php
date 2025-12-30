<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $userId = Auth::id();
        
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $rules = [
            'name'  => 'required|string|min:2|max:50',
            'email' => 'required|string|email|max:100|unique:users,email,' . $userId,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $messages = [
            'name.required'     => 'Name is required',
            'name.min'          => 'Name must be at least 2 characters',
            'name.max'          => 'Name cannot exceed 50 characters',
            'email.required'    => 'Email is required',
            'email.email'       => 'Please enter a valid email address',
            'email.unique'      => 'This email is already taken',
            'password.required' => 'Password is required when changing',
            'password.min'      => 'Password must be at least 8 characters',
            'password.confirmed'=> 'Password confirmation does not match',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        DB::table('users')
            ->where('id', $userId)
            ->update($updateData);

        if ($request->session()) {
            $request->session()->put('name', $request->name);
        }

        return redirect()->route('profile')
            ->with('success', 'Profile updated successfully!');
    }
}
