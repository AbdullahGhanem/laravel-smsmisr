<?php

namespace Ghanem\LaravelSmsmisr;

use \Illuminate\Support\ServiceProvider;

class SmsmisrServiceProvider extends ServiceProvider
{
    /**
     * @var bool $defer Indicates if loading of the provider is deferred.
     */
    protected $defer = true;

    /** 
     * [$configName description]
     * @var string
     */
    protected $configName = 'smsmisr';

    public function register()
    {
        $this->app->singleton('smsmisr', function($app) {
            return new Smsmisr();
        });

        $this->app->bind('smsmisr', function($app) {
            return new Smsmisr();
        });

        $this->app->alias('smsmisr', Smsmisr::class);
    }

    public function boot()
    {
        $configPath = __DIR__ . '/../config/' . $this->configName . '.php';
        $this->publishes([$configPath => config_path($this->configName . '.php')], 'config');
        $this->mergeConfigFrom($configPath, $this->configName);
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('smsg',           Smsmisr::class,);
    }
}
