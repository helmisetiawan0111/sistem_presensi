<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string[]  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $userRoleLower = strtolower($user->role);
        $rolesLower = array_map('strtolower', $roles);

        if (!in_array($userRoleLower, $rolesLower)) {
            // Redirect based on user's role to their appropriate dashboard
            return redirect()->route($this->getDashboardRouteForRole($user->role))
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }

    /**
     * Get the dashboard route name for a given role.
     *
     * @param string $role
     * @return string
     */
    protected function getDashboardRouteForRole(string $role): string
    {
        return match (strtolower($role)) {
            'admin' => 'admin.dashboard',
            'petugas' => 'petugas.dashboard',
            'santri' => 'santri.dashboard',
            default => 'dashboard',
        };
    }
}