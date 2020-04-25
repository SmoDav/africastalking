<?php

namespace SmoDav\AfricasTalking\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Token
 *
 * @category PHP
 *
 * @method static \AfricasTalking\SDK\Token createCheckoutToken(array $options)
 * @method static \AfricasTalking\SDK\Token generateAuthToken()
 *
 * @see \AfricasTalking\SDK\Token
 */
class Token extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'at_token';
    }
}
