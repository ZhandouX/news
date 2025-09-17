<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

class ValidateSignature extends Middleware
{
    /**
     * Daftar query string yang harus diabaikan saat memverifikasi signature.
     *
     * @var array<int, string>
     */
    protected $ignore = [
        // Contoh: 'utm_campaign', 'fbclid'
    ];
}
