<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected function redirectTo(Request $request, Closure $next): Response
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
        return $next($request);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $guard = null): Response
    {
        if ($this->auth->guard('web')->check()) {
            Log::info('User is authenticated');
        } else {
            Log::info('User is not authenticated');
        }

        return parent::handle($request, $next, ...$guards);

        // if (Auth::guard($guard)->guest()) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return $next($request);
    }
}
