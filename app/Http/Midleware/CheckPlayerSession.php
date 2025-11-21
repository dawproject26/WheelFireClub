<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPlayerSession
{
    public function handle($request, Closure $next)
{
    if (!session()->has('player_id')) {
        return redirect()->route('/');
    }

    return $next($request);
}

}