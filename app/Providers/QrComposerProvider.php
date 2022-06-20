<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class QrComposerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->composeQr();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function composeQr()
    {
        view()->composer('partials.qrcode', 'App\Http\Composers\QrComposer');
    }
}
