<?php

namespace Sosupp\SlimDashboard;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


class SlimDashboardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'slim-dashboard');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'slim-dashboard');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // $this->loadViewComponentsAs('slim-dashboard', [

        // ]);

        Blade::componentNamespace('SlimDashboard\\Views\\Components', 'slim-dashboard');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('slim-dashboard.php'),
            ], 'slim-dashboard-config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/slim-dashboard'),
            ], 'views');*/

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/slim-dashboard'),
            ], 'slim-dashboard-assets');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/slim-dashboard'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'slim-dashboard');

        // Register the main class to use with the facade
        $this->app->singleton('slim-dashboard', function () {
            return new SlimDashboard;
        });
    }
}
