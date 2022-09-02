<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use App\Models\Company;

class TimeZoneProveder extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       // Config::set('app.timezone', Company::where('id', 1)->value('time_zone'));
      
    }
}
