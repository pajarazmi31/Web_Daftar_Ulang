<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Form Login
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $credential = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember = $request->has('remember');

        if (!Auth::attempt($credential, $remember)) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Email atau Password salah.'
                ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role->nama_role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role->nama_role == 'operator') {
            return redirect()->route('operator.dashboard');
        }

        if ($user->role->nama_role == 'kepsek') {
            return redirect()->route('kepsek.dashboard');
        }

        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
