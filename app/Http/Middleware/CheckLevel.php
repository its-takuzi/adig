<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CheckLevel
{
    public function handle(Request $request, Closure $next, ...$levels)
    {
        Log::info('CheckLevel middleware triggered for role: ' . $request->user()->role);
        if (in_array($request->user()->role, $levels)) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke fitur ini.');
    }
}
