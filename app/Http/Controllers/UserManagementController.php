<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Santri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where(function($q) {
            $q->whereIn('role', ['admin', 'petugas'])
              ->orWhere(function($q2) {
                  $q2->where('role', 'santri')
                     ->whereHas('santo', function($q3) {
                         $q3->where('status', true);
                     });
              });
        });

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->orderBy('role')->orderBy('name')->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        if ($user->role === 'admin' && $user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa reset password sendiri.');
        }

        if ($user->role === 'petugas') {
            $defaultPassword = 'password123';
        } else {
            $defaultPassword = $user->nis ?? $user->username;
        }
        $user->password = Hash::make($defaultPassword);
        $user->save();

        return back()->with('success', "Password berhasil direset ke: {$defaultPassword}");
    }
}