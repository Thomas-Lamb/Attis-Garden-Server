<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Bac;
use App\Models\User;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class EnsureApiTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $api_token = $request->input('api_token');
        $bac_token = $request->input('bac_token');
        if ($api_token != null) {
            if (User::firstWhere('api_token', $api_token)) {
                return $next($request);
            }
        }
        else if ($bac_token != null) {
            if (Bac::firstWhere('bac_token', $bac_token)) {
                return $next($request);
            }
        }
        return response()->json([
            'state' => 'Invalid api_token',
        ], 400);
    }
}
