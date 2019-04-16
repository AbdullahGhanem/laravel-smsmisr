<?php

namespace Ghanem\LaravelSmsmisr;

use \Illuminate\Support\ServiceProvider

class ServiceProvider extends ServiceProvider
{
    /** @var bool $defer */
    protected $defer = false;
    /** @var string $configName */
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
