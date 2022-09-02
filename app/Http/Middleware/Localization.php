<?php

namespace App\Http\Middleware;
use App\Models\Company;
use config;
use Closure;




class Localization
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
      
 //   Config::set('app.locale', Company::where('id', 1)->value('language'));
         if(\Session::has('locale')){
            \App::setLocale(\Session::get('locale'));
        } 
        return $next($request);
    }
}
