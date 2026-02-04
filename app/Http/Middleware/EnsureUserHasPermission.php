<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        switch ($permission) {
            case 'full':
                if (!$user->isFullAdmin()) {
                    abort(403, 'Unauthorized action. Full administrative access required.');
                }
                break;
            case 'create':
                if (!$user->canCreate()) {
                    abort(403, 'Unauthorized action. Create permissions required.');
                }
                break;
            case 'view':
                // All authenticated users have at least view access in this simple tier system
                break;
            default:
                abort(403, 'Invalid permission requirement.');
        }

        return $next($request);
    }
}
