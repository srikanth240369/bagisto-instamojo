<?php

namespace Srikanth\Instamojo\Providers;

use Illuminate\Support\ServiceProvider;

class BagistoInstaMojoServiceProvider extends ServiceProvider
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
        include __DIR__ . '/../Http/routes.php';

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'instamojo');
    }
}