<?php

namespace App\Http\Middleware;

use Closure;

class hasSupplier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!\App\Supplier::count()){
            return redirect(route('suppliers.index'))->withSuccess('Please add suppliers first!');
        }
        return $next($request);
    }
}
