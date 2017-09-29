<?php

namespace SmoDav\AfricasTalking\Laravel;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider as RootProvider;
use SmoDav\AfricasTalking\Contracts\ConfigurationStore;
use SmoDav\AfricasTalking\Engine\Mailman;
use SmoDav\AfricasTalking\Engine\Subscriber;
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
     */
    public function register()
    {
        $this->bindInstances();

        $this->registerFacades();
    }

    private function bindInstances()
    {
        $this->app->bind(ConfigurationStore::class, LaravelConfig::class);
        $this->app->bind(ClientInterface::class, function () {
            return new Client();
        });
    }

    private function registerFacades()
    {
        $this->app->bind('at_sms', function () {
            return $this->app->make(Mailman::class);
        });
        $this->app->bind('at_subscriber', function () {
            return $this->app->make(Subscriber::class);
        });
    }
}
