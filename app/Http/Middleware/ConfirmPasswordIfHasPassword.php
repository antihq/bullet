<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\RequirePassword;

class ConfirmPasswordIfHasPassword extends RequirePassword
{
    public function handle($request, Closure $next, $redirectToRoute = null, $passwordTimeoutSeconds = null)
    {
        // Skip password confirmation if user has no password
        if (is_null($request->user()?->password)) {
            return $next($request);
        }

        // Otherwise, require password confirmation as normal
        return parent::handle($request, $next, $redirectToRoute, $passwordTimeoutSeconds);
    }
}
