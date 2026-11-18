<?php
namespace App\Http\Middleware;
use Closure;
class Role {
    public function handle($r, Closure $next, ...$roles) {
        abort_unless(auth()->check() && in_array(auth()->user()->role, $roles), 403, 'You do not have permission to view this page.');
        return $next($r);
    }
}
