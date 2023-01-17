<?php

namespace DiagVN\Encrypt;

use Illuminate\Support\ServiceProvider;

class EncryptServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                //file source => file destination below
                __DIR__ . '/Config/encrypt.php' => config_path('encrypt.php'),
                //you can also add more configs here
            ]
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}