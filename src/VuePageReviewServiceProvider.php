<?php

namespace TS2201\VuePageReview;

use Illuminate\Support\ServiceProvider;

class PageReviewServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ts2201');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'vuepagereview');
        // $this->load(__DIR__.'/../resources/views', 'vuepagereview');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->app['router']->namespace('TS2201\\VuePageReview\\Controllers')
                ->middleware(['web'])
                ->group(function () {
                    $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
                });

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/vuepagereview.php', 'vuepagereview');

        // Register the service the package provides.
        $this->app->singleton('vuepagereview', function ($app) {
            return new VuePageReview;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['vuepagereview'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/vuepagereview.php' => config_path('vuepagereview.php'),
        ], 'vuepagereview.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/ts2201'),
        ], 'vuepagereview.views');

        $this->publishes([
            __DIR__.'/../resources/js/' => resource_path('js/vendor/ts2201'),
        ], 'public.js');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/ts2201'),
        ], 'vuepagereview.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ts2201'),
        ], 'vuepagereview.views');*/

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');
        
        // Registering package commands.
        // $this->commands([]);
    }
}
