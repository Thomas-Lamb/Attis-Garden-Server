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
        $inputs = $request->validate([
            'bac_token' => ['required']
        ]);
        if ($bac = Bac::where('bac_token', $inputs['bac_token'])->first()) {
            $request['bac'] = $bac;
            return $next($request);
        }
        return response()->json([
            'state' => 'Invalid bac_token',
        ], 400);
    }
}
