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
        view()->composer('admin.misc.most-documents-per-office', 'App\Http\Composers\QrComposer');
        view()->composer('admin.misc.most-types', 'App\Http\Composers\QrComposer');
    }
}
