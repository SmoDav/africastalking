<?php

namespace SmoDav\AfricasTalking\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class SMS
 *
 * @category PHP
 *
 * @method static \AfricasTalking\SDK\SMS send(array $options)
 * @method static \AfricasTalking\SDK\SMS sendPremium(array $options)
 * @method static \AfricasTalking\SDK\SMS fetchMessages(array $options = [])
 * @method static \AfricasTalking\SDK\SMS createSubscription array ($options)
 * @method static \AfricasTalking\SDK\SMS deleteSubscription array ($options)
 * @method static \AfricasTalking\SDK\SMS fetchSubscriptions(array $options)
 *
 * @see \AfricasTalking\SDK\SMS
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
