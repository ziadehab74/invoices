<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class TelescopeAuthorize
{
    public function handle($request, Closure $next)
    {
        if (app()->environment('local') || Gate::allows('viewTelescope')) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');

        // You can customize the response or redirect logic as needed.
    }
}
