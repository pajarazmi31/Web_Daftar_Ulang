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
        // 1. Ubah validasi agar menerima input berupa 'login_input' (bisa NISN atau Email)
        $request->validate([
            'email' => ['required'], // Tetap biarkan namanya 'email' jika name di HTML input Anda adalah name="email"
            'password' => ['required'],
        ]);

        // 2. Karena data NISN siswa disimpan di dalam kolom 'email' pada tabel users,
        // kita tetap mencocokkan input user ($request->email) ke kolom 'email' di database Laravel.
        $credential = [
            'email' => $request->email, 
            'password' => $request->password,
        ];

        $remember = $request->has('remember');

        // 3. Proses Autentikasi ke Database
        if (!Auth::attempt($credential, $remember)) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Email/NISN atau Password yang Anda masukkan salah.'
                ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // 4. Pengalihan halaman (Redirect) berdasarkan Role setelah berhasil Login
        if ($user->role->nama_role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role->nama_role == 'operator') {
            // Jika route dashboard operator Anda menyatu atau berbeda silakan disesuaikan
            return redirect()->route('operator.dashboard'); 
        }

        if ($user->role->nama_role == 'siswa') {
            // Diarahkan ke dashboard khusus siswa yang baru dibuat
            return redirect()->route('siswa.dashboard');
        }

        if ($user->role->nama_role == 'kepsek') {
            return redirect()->route('laporan.kepsek'); // Sesuaikan dengan nama route kepsek Anda
        }

        // Keamanan tambahan jika role tidak dikenali
        Auth::logout();
        return redirect()->route('login')->with('error', 'Akses ditolak. Role pengguna tidak sah.');
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