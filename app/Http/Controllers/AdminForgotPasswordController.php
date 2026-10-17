<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class AdminForgotPasswordController extends Controller
{
    public function show()
    {
        return view('auth.admin-forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'login' => 'required|string|exists:users,username',
            'email_verification' => 'required|email',
        ]);

        $user = User::where('username', $request->login)
            ->where('role', 'admin')
            ->first();

        if (!$user || !$user->email) {
            return back()->withErrors(['login' => 'Username admin tidak ditemukan atau email belum diset.']);
        }

        if (strtolower($request->email_verification) !== strtolower($user->email)) {
            return back()->withErrors(['email_verification' => 'Email tidak cocok dengan username admin.']);
        }

        $token = Str::random(60);
        
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['email' => $user->email, 'token' => $token, 'created_at' => now()]
        );

        $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));
        
        Mail::raw("Reset password Anda: {$resetUrl}\n\nLink berlaku 60 menit.", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Reset Password Admin - Presensi Al Asyariyyah');
        });

        return back()->with('status', 'Link reset telah dikirim ke email Anda.');
    }
}