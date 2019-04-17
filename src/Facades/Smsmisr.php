<?php
namespace Ghanem\LaravelSmsmisr\Facades;

use Illuminate\Support\Facades\Facade;

class Smsmisr extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'smsmisr';
    }
}