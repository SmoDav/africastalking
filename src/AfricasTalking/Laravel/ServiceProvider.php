<?php

namespace SmoDav\AfricasTalking\Laravel;

use Illuminate\Support\ServiceProvider as RootProvider;
use SmoDav\AfricasTalking\Contracts\ConfigurationStore;
use SmoDav\AfricasTalking\Engine\Runner;
use SmoDav\AfricasTalking\Laravel\Stores\LaravelConfig;

class ServiceProvider extends RootProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../config/africastalking.php' => config_path('africastalking.php')
        ]);
    }

    /**
     * Registrar the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindInstances();

        $this->registerFacades();
    }

    /**
     * Bind the Interfaces.
     *
     * @return void
     */
    private function bindInstances()
    {
        $this->app->bind(ConfigurationStore::class, LaravelConfig::class);

        $this->app->singleton(Runner::class, function ($app) {
            return new Runner($app->make(ConfigurationStore::class));
        });
    }

    /**
     * Register the facades.
     *
     * @return void
     */
    private function registerFacades()
    {
        $this->app->bind('at_app', function () {
            return $this->app->make(Runner::class)->application();
        });

        $this->app->bind('at_airtime', function () {
            return $this->app->make(Runner::class)->airtime();
        });

        $this->app->bind('at_sms', function () {
            return $this->app->make(Runner::class)->sms();
        });

        $this->app->bind('at_payments', function () {
            return $this->app->make(Runner::class)->payments();
        });

        $this->app->bind('at_voice', function () {
            return $this->app->make(Runner::class)->voice();
        });

        $this->app->bind('at_token', function () {
            return $this->app->make(Runner::class)->token();
        });
    }
}
