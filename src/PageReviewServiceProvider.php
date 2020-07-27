<?php

namespace Laramore\PageReview;

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
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laramore');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'pagereview');
        // $this->load(__DIR__.'/../resources/views', 'pagereview');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->app['router']->namespace('Laramore\\PageReview\\Controllers')
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
        $this->mergeConfigFrom(__DIR__.'/../config/pagereview.php', 'pagereview');

        // Register the service the package provides.
        $this->app->singleton('pagereview', function ($app) {
            return new PageReview;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['pagereview'];
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
            __DIR__.'/../config/pagereview.php' => config_path('pagereview.php'),
        ], 'pagereview.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/laramore'),
        ], 'pagereview.views');

        $this->publishes([
            __DIR__.'/../resources/js/' => resource_path('js/vendor/laramore'),
        ], 'public.js');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/laramore'),
        ], 'pagereview.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/laramore'),
        ], 'pagereview.views');*/

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');
        
        // Registering package commands.
        // $this->commands([]);
    }
}
