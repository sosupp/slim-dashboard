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
use Sosupp\SlimDashboard\Console\Slimer\MakeSlimerMenus;
use Sosupp\SlimDashboard\View\Components\Dashboard\Navigations;

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
        $this->registerRoutes();

        Blade::componentNamespace('SlimDashboard\\Views\\Components', 'slim-dashboard');
        Blade::component('navigations', Navigations::class, 'slimer');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('slim-dashboard.php'),
            ], 'slimer-config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/slim-dashboard'),
            ], 'slimer-views');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/slim-dashboard'),
            ], 'slimer-assets');

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
                MakeServiceCommand::class,
                MakeSlimerMenus::class,
            ]);
        }
    }
}
