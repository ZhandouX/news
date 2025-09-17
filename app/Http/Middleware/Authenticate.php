<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Redirect jika tidak login.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login'); // Pastikan rute ini ada
        }
    }
}
