<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            $available_locales = collect(config('app.available_locales'));
            if ($available_locales->contains($locale)) {
                App::setLocale($locale);
            } else {
                App::setLocale('en');
            }
        }

        return $next($request);
    }
}
