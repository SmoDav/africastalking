<?php

namespace SmoDav\AfricasTalking\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Application
 *
 * @category PHP
 *
 * @method static \AfricasTalking\SDK\Application doFetchApplication()
 * @method static \AfricasTalking\SDK\Application fetchApplicationData()
 *
 * @see \AfricasTalking\SDK\Application
 */
class Application extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'at_app';
    }
}
