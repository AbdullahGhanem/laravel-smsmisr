<?php

namespace Ghanem\LaravelSmsmisr;

use Ghanem\LaravelSmsmisr\Smsmisr;
use \Illuminate\Support\ServiceProvider;

class SmsmisrServiceProvider extends ServiceProvider
{
    /**
     * @var bool $defer Indicates if loading of the provider is deferred.
     */
    protected $defer = false;


    public function boot()
    {
        $this->publishes([$this->configPath() => config_path('smsmisr.php')]);
    }

    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'config');

        $this->app->singleton('smsmisr', function($app) {
            return new Smsmisr();
        });

        $this->app->bind('smsmisr', function($app) {
            return new Smsmisr();
        });

        $this->app->alias('smsmisr', Smsmisr::class);
    }



    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('smsmisr', Smsmisr::class);
    }


    protected function configPath()
    {
        return __DIR__ . '/../config/smsmisr.php';
    }
}
