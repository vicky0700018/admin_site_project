<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (in_array($user->role, ['admin', 'subadmin'])) {
                // Redirect based on role
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('subadmin.dashboard');
                }
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'You are not authorized to access this portal']);
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}
