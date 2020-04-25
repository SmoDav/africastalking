<?php

namespace SmoDav\AfricasTalking\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Voice
 *
 * @category PHP
 *
 * @method static \AfricasTalking\SDK\Voice call(array $options)
 * @method static \AfricasTalking\SDK\Voice fetchQueuedCalls(array $options)
 * @method static \AfricasTalking\SDK\Voice uploadMediaFile(array $options)
 * @method static \AfricasTalking\SDK\Voice messageBuilder()
 * @method static \AfricasTalking\SDK\Voice build()
 *
 * @see \AfricasTalking\SDK\Voice
 */
class Voice extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'at_voice';
    }
}
