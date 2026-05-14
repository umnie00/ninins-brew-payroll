<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isEmployee()) {
            return redirect()->route('dashboard')
                ->with('error', 'Access denied.');
        }

        return $next($request);
    }
}