<?php

namespace App\Providers;

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MiscFunctionProvider extends ServiceProvider
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
        //
        View::composer('*', function ($view) {
            $controller = new DashboardController();
            $documents = $controller->mostDocumentsByOffice();
            $documentTypes = $controller->mostTypes();
            $view->with(['documents' => $documents, 'documentTypes' => $documentTypes]);
        });
    }
}
