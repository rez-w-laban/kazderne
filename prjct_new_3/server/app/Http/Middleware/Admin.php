<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->role_id == "1") {
            return $next($request);
        }
        return response()->json([
            "status" => "error",
            'message' => 'Unauthorized : only admins can access this page',
        ]);
    }
}
