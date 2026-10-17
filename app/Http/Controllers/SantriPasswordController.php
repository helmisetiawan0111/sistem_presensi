<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SantriPasswordController extends Controller
{
    /**
     * Show the password change form.
     */
    public function edit()
    {
        return view('auth.santri-password-change');
    }

    /**
     * Update the password.
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // For santri, if must_change_password is true, current_password might be NIS (not hashed?) 
        // Actually we store hashed password. So we check against hashed.
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password saat ini salah.',
            ]);
        }

        // Update the password
        $user->password = Hash::make($request->password);
        // If they were forced to change password, now set flag to false
        $user->must_change_password = false;
        $user->save();

        return redirect()->route('santri.dashboard')->with('status', 'password-updated');
    }
}