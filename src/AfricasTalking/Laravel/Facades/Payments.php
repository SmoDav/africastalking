<?php

namespace SmoDav\AfricasTalking\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Payments
 *
 * @category PHP
 *
 * @method static \AfricasTalking\SDK\Payments mobileCheckout(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments mobileB2C(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments mobileB2B(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments mobileData(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments bankCheckoutCharge(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments bankCheckoutValidate(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments bankTransfer(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments cardCheckoutCharge(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments cardCheckoutValidate(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments walletTransfer(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments topupStash(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments fetchProductTransactions(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments fetchWalletTransactions(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments findTransaction(array $parameters, array $options)
 * @method static \AfricasTalking\SDK\Payments fetchWalletBalance(array $parameters, array $options)
 *
 * @see \AfricasTalking\SDK\Payments
 */
class Payments extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'at_payments';
    }
}
