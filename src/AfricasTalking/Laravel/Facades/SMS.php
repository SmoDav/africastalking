<?php

namespace SmoDav\AfricasTalking\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class SMS
 *
 * @category PHP
 *
 * @author   David Mjomba <smodavprivate@gmail.com>
 */
class SMS extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'at_sms';
    }
}
