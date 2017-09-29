<?php

namespace SmoDav\AfricasTalking\Config;

use GuzzleHttp\ClientInterface;
use SmoDav\AfricasTalking\Contracts\ConfigurationStore;

/**
 * Class Config.
 *
 * @category PHP
 *
 * @author   David Mjomba <smodavprivate@gmail.com>
 */
class Config
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $apiKey;

    /**
     * @var string
     */
    public $sandbox;

    /**
     * @var bool
     */
    public $debug;

    /**
     * @var string
     */
    private $rootURL = 'africastalking.com';

    /**
     * The api endpoint prefix.
     */
    const API = 'api.';

    /**
     * The payment endpoint prefix.
     */
    const PAYMENT = 'payment.';

    /**
     * The voice endpoint prefix.
     */
    const VOICE = 'voice.';

    /**
     * @var ConfigurationStore
     */
    private $store;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var Config
     */
    public static $instance;

    /**
     * AuthConfig constructor.
     *
     * @param ConfigurationStore $store
     * @param ClientInterface    $client
     */
    public function __construct(ConfigurationStore $store, ClientInterface $client)
    {
        $this->store = $store;
        $this->client = $client;
        $this->setupConfigs();
        self::$instance = $this;
    }

    /**
     * Setup the configuration.
     */
    private function setupConfigs()
    {
        $this->username = $this->store->get('africastalking.username');
        $this->apiKey = $this->store->get('africastalking.api_key');
        $this->debug = $this->store->get('africastalking.debug');
        $this->sandbox = $this->store->get('africastalking.sandbox') ? 'sandbox.' : '';
    }

    /**
     * Get the current client instance;
     *
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Generate a full URL for a transaction.
     *
     * @param $type
     * @param string $extension
     *
     * @return string
     */
    public function getUrl($type, $extension = '')
    {
        return 'https://' . $type . $this->sandbox . $this->rootURL . $extension;
    }

    /**
     * Get the SMS URL.
     *
     * @param string $extension
     *
     * @return string
     */
    public function getSMSUrl($extension = '')
    {
        return $this->getUrl(self::API, '/version1/messaging' . $extension);
    }

    /**
     * Get the User URL.
     *
     * @param $extension
     *
     * @return string
     */
    public function getUserURL($extension)
    {
        return $this->getUrl(self::API, '/version1/user' . $extension);
    }

    public function getSubscriptionURL($extension = '')
    {
        return $this->getUrl(self::API, '/version1/subscription'. $extension);
    }

    public function getTokenURL()
    {
        return $this->getUrl(self::API, '/checkout/token/create');
    }
}
