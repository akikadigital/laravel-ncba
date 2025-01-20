<?php

namespace Akika\LaravelNCBA;

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
        $this->app->bind('mpesa', function () {
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
        // Load package migrations
        if ($this->app->runningInConsole()) {

            // Publish the ncba config file
            $this->publishes([
                __DIR__ . '/../config/ncba.php' => config_path('ncba.php')
            ], 'config'); // Register InstallAkikaNcbaLaravelPackage command

            // Register InstallAkikaNcbaLaravelPackage command
            $this->commands([
                Commands\InstallAkikaNCBALaravelPackage::class,
            ]);
        }
    }
}
