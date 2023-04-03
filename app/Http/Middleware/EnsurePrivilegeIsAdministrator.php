<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsurePrivilegeIsAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $api_token = $request->input('api_token');
        if ($api_token != null) {
            if (User::firstWhere('api_token', $api_token)->privilege <= 0) {
                return $next($request);
            }
            else {
                return response()->json([
                    'state' => 'Invalid privilege',
                ], 400);
            }
        }
        return response()->json([
            'state' => 'Invalid or missing api_token',
        ], 400);
    }
}
