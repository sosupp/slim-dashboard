<?php

namespace Sosupp\SlimDashboard;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Sosupp\SlimDashboard\Console\MakeFormCommand;
use Sosupp\SlimDashboard\Console\MakePageCommand;
use Sosupp\SlimDashboard\Console\MakeTableCommand;
use Sosupp\SlimDashboard\Console\MakeServiceCommand;
use Sosupp\SlimDashboard\Console\MakeTabWrapperCommand;

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

        // $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->registerRoutes();

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

            $this->customCommands();
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

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('slim-dashboard.prefix'),
            'middleware' => config('slim-dashboard.middleware'),
        ];
    }

    protected function customCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeTableCommand::class,
                MakeFormCommand::class,
                MakePageCommand::class,
                MakeTabWrapperCommand::class,
                MakeServiceCommand::class
            ]);
        }
    }
}
