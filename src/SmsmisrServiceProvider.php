<?php

namespace Ghanem\LaravelSmsmisr;

use \Illuminate\Support\ServiceProvider;

class SmsmisrServiceProvider extends ServiceProvider
{
    /**
     * @var bool $defer Indicates if loading of the provider is deferred.
     */
    protected $defer = false;

    /** 
     * [$configName description]
     * @var string
     */
    protected $configName = 'smsmisr';

    public function register()
    {
        $configPath = __DIR__ . '/../config/' . $this->configName . '.php';

        $this->mergeConfigFrom($configPath, $this->configName);

        $this->app->bind(Smsmisr::class, Smsmisr::class);

        $this->app->singleton('smsmisr', function($app) {
            return new Smsmisr($app);
        });

        $this->app->alias('smsmisr', Smsmisr::class);
    }

    public function boot()
    {
        $configPath = __DIR__ . '/../config/' . $this->configName . '.php';

        $this->publishes([$configPath => config_path($this->configName . '.php')], 'config');
    }
}
