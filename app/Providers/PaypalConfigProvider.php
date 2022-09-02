<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use App\Models\SaleConfig;

class PaypalConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $paypalconfig = SaleConfig::where(['id' => 1])->latest()->first();
        if ($paypalconfig) {
            $config = array(
                'PAYPAL_SANDBOX_API_USERNAME'=> $paypalconfig->paypal_username,
                'PAYPAL_SANDBOX_API_PASSWORD'=> $paypalconfig->paypal_password,
                'PAYPAL_SANDBOX_API_SECRET'=> $paypalconfig->paypal_secret,
                 'app_id'   => 'APP-80W284485P519543T'
            );
            Config::set('paypal', $config);
        }
    }
}
