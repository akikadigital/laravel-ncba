<?php

namespace Akika\LaravelNcba;

use Illuminate\Support\ServiceProvider;

class NcbaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ncba', function () {
            return new Ncba();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /// Load the routes
        if ($this->app->runningInConsole()) {

            /// Publish the ncba config file
            $this->publishes([
                __DIR__ . '/../config/ncba.php' => config_path('ncba.php')
            ], 'config'); /// php artisan vendor:publish --tag=config

            /// Publish the ncba migrations
            $this->commands([
                Commands\InstallAkikaNcbaLaravelPackage::class,
            ]);
        }
    }
}
