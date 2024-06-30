<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        $user = Auth::user();
        if ($user) {
            return $next($request);
        }

        return response()->json([
            "status" => "error",
            'message' => 'Unauthorized blbla',
        ]);
    }
}
