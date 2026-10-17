<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use App\Models\User;

class SimpleLoginController extends Controller
{
    public function show()
    {
        return view('auth.simple-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        $user = User::where('username', $login)
            ->orWhere('nis', $login)
            ->first();

        if ($user) {
            $authenticated = false;
            if ($user->role === 'santri' && $user->must_change_password) {
                // For santri with default password (not yet changed), password should be NIS
                // But we store hashed password of NIS.
                if (Hash::check($login, $user->password)) {
                    $authenticated = true;
                }
            } else {
                // For other users or santri who already changed password, use normal credential check
                if (Hash::check($password, $user->password)) {
                    $authenticated = true;
                }
            }

            if ($authenticated) {
                $remember = $request->has('remember');
                Auth::login($user, $remember);
                $request->session()->regenerate();

                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role === 'petugas') {
                    return redirect()->route('petugas.dashboard');
                } elseif ($user->role === 'santri') {
                    return redirect()->route('santri.dashboard');
                }

                return redirect()->route('admin.dashboard');
            }
        }

        return back()->withErrors([
            'login' => 'Login atau kata sandi salah.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}