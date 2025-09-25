<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    // Menampilkan halaman login
    public function create()
    {
        return view('auth.login');
    }

    // Menangani login
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek kredensial login
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Redirect setelah login berhasil
            return redirect()->intended('/dashboard');  // Ganti '/dashboard' sesuai tujuan kamu
        }

        // Jika login gagal, kembali ke halaman login dengan error
        return back()->withErrors([
            'username' => 'Username atau Password salah',
        ]);
    }

    // Menangani logout
    public function destroy(Request $request)
    {
        Auth::logout();  // Logout pengguna
        $request->session()->invalidate();  // Menghapus session
        $request->session()->regenerateToken();  // Regenerasi token

        return redirect('/');  // Redirect ke halaman utama setelah logout
    }
}
