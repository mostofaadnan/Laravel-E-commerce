<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MailConfigation;


class MailConfigServiceProvider extends ServiceProvider
{

    //https://codingdriver.com/dynamic-mail-configuration-in-laravel-with-values.html
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
     
        /* $emailServices = MailConfigation::where(['id' => 1])->latest()->first();

        if ($emailServices) {
            $config = array(
                'driver'     => $emailServices->driver,
                'host'       => $emailServices->host,
                'port'       => $emailServices->port,
                'username'   => $emailServices->username,
                'password'   => $emailServices->password,
                'encryption' => $emailServices->encryption,
                'from'       => array('address' => $emailServices->email, 'name' => $emailServices->name),
                'sendmail'   => '/usr/sbin/sendmail -bs',
                'pretend'    => false,
            );

            Config::set('mail', $config);
        } */
    }
}
