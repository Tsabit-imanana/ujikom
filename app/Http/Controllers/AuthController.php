<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login admin.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali, '.Auth::user()->name.'!');
        }

        return back()->withErrors([
            'email' => 'Kombinasi email dan kata sandi tidak cocok.',
        ])->onlyInput('email');
    }

    /**
     * Login cepat akun demo untuk penguji/asesor.
     */
    public function loginDemo(Request $request): RedirectResponse
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@ujikom.test'],
            [
                'name' => 'Administrator Pegawai',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($admin);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Berhasil login otomatis sebagai Administrator.');
    }

    /**
     * Keluar dari sistem.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}
