<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;



class check_password_api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define the expected API password from the environment variables
        $expectedPassword = env("API_PASSWORD", "FZbtQlABjsbMDmMih9tA83eZ43RB31lUf1sMDDc");

        // Check if the provided API password matches the expected password
        if ($request->api_password !== $expectedPassword) {
            // Return an unauthorized JSON response if the password does not match
            return response()->json(['message' => "unauthenticated"], Response::HTTP_UNAUTHORIZED);
        }

        // If the password matches, proceed with the request
        return $next($request);
    }
}