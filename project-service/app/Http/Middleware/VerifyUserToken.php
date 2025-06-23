<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyUserToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (! $token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        // Replace with the correct URL of your user-service
        $response = Http::withToken($token)->get('http://localhost:8000/api/user');

        if ($response->failed()) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $request->merge(['user' => $response->json()]);
        return $next($request);
    }
}

