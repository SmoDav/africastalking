<?php

namespace SmoDav\AfricasTalking\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Airtime
 *
 * @category PHP
 *
 * @method static \AfricasTalking\SDK\Airtime send(array $parameters, array $options = [])
 *
 * @see \AfricasTalking\SDK\Airtime
 */
class Airtime extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'at_airtime';
    }
}
