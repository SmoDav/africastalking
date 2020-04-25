<?php

namespace SmoDav\AfricasTalking\Engine;

use AfricasTalking\SDK\AfricasTalking;
use AfricasTalking\SDK\Airtime;
use AfricasTalking\SDK\Application;
use AfricasTalking\SDK\Payments;
use AfricasTalking\SDK\SMS;
use AfricasTalking\SDK\Token;
use AfricasTalking\SDK\Voice;
use Exception;
use SmoDav\AfricasTalking\Contracts\ConfigurationStore;

class Runner
{
    /**
     * @var ConfigurationStore
     */
    protected $store;

    /**
     * The current instance
     *
     * @var self
     */
    protected static $instance;

    /**
     * If the runner has booted.
     *
     * @var bool
     */
    protected static $booted = false;

    /**
     * The current Africa's Talking instance.
     *
     * @var AfricasTalking
     */
    protected $runner;

    /**
     * Create a new instance.
     *
     * @param ConfigurationStore $store
     */
    public function __construct(ConfigurationStore $store)
    {
        $this->store = $store;
        $this->boot();
    }

    /**
     * Boot up the runner.
     *
     * @return void
     */
    protected function boot(): void
    {
        $this->runner = new AfricasTalking(
            $this->store->get('africastalking.username'),
            $this->store->get('africastalking.api_key')
        );

        self::$booted = true;
        self::$instance = $this;
    }

    /**
     * Check if the runner has booted.
     *
     * @return bool
     */
    public static function booted(): bool
    {
        return self::booted();
    }

    /**
     * Get the current instance.
     *
     * @throws Exception
     *
     * @return self
     */
    public static function instance(): self
    {
        if (self::$instance) {
            return self::$instance;
        }

        if (!function_exists('app')) {
            throw new Exception('First initialise the instance using new Runner(ConfigurationStore $store).');
        }

        return app()->make(Runner::class);
    }

    /**
     * Get the SMS Instance.
     *
     * @return SMS
     */
    public function sms(): SMS
    {
        return self::instance()->runner->sms();
    }

    /**
     * Get the Airtime Instance.
     *
     * @return Airtime
     */
    public function airtime(): Airtime
    {
        return self::instance()->runner->airtime();
    }

    /**
     * Get the Payments Instance.
     *
     * @return Payments
     */
    public function payments(): Payments
    {
        return self::instance()->runner->payments();
    }

    /**
     * Get the Voice Instance.
     *
     * @return Voice
     */
    public function voice(): Voice
    {
        return self::instance()->runner->voice();
    }

    /**
     * Get the Token Instance.
     *
     * @return Token
     */
    public function token(): Token
    {
        return self::instance()->runner->token();
    }

    /**
     * Get the Application Instance.
     *
     * @return Application
     */
    public function application(): Application
    {
        return self::instance()->runner->application();
    }
}
