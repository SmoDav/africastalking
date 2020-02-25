<?php

namespace SmoDav\AfricasTalking\Engine;

use GuzzleHttp\Exception\RequestException;
use SmoDav\AfricasTalking\Config\Config;
use SmoDav\AfricasTalking\Exceptions\GatewayException;

/**
 * Class Subscriber.
 *
 * @category PHP
 *
 * @author   David Mjomba <smodavprivate@gmail.com>
 */
class Subscriber
{
    /**
     * @var string
     */
    protected $mobile;

    /**
     * @var string
     */
    protected $shortCode;

    /**
     * @var string
     */
    protected $keyword;

    /**
     * @var string
     */
    protected $token;
    /**
     * @var Config
     */
    private $config;

    private $subscribe = true;

    /**
     * Subscriber constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Create the request and initiate the call.
     *
     * @param $endpoint
     * @param array  $body
     * @param string $method
     *
     * @return array|mixed
     */
    private function sendRequest($endpoint, $body = [], $method = 'POST')
    {
        $client = $this->config->getClient();
        $options = [
            'headers' => [
                'apikey' => $this->config->apiKey,
                'Content-Type'  => 'application/x-www-form-urlencoded',
                'Accept'  => 'application/json',
            ],
            'form_params' => $body,
        ];

        if ($method == 'GET' && count($body)) {
            $options['query'] = $body;
            unset($options['form_params']);
        }

        try {
            $response = $client->request($method, $endpoint, $options);

            $body = \json_decode($response->getBody());

            if ($this->config->debug) {
                var_dump($body);
            }

            return $body;
        } catch (RequestException $exception) {
            throw $exception;
        }
    }

    /**
     * Set the mobile number to be subscribed.
     *
     * @param $mobile
     *
     * @return $this
     *
     * @throws GatewayException
     */
    public function subscribe($mobile)
    {
        if (! strlen($mobile)) {
            throw new GatewayException('Please enter a valid mobile number.');
        }

        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Set the mobile number to be subscribed.
     *
     * @param $mobile
     *
     * @return $this
     *
     * @throws GatewayException
     */
    public function unsubscribe($mobile)
    {
        $this->subscribe($mobile);
        $this->subscribe = false;

        return $this;
    }

    /**
     * Setup the short-code.
     *
     * @param $shortCode
     *
     * @return $this
     *
     * @throws GatewayException
     */
    public function toCode($shortCode)
    {
        if (! strlen($shortCode)) {
            throw new GatewayException('Please enter a valid short-code.');
        }

        $this->shortCode = $shortCode;

        return $this;
    }

    /**
     * Setup the short-code.
     *
     * @param $shortCode
     *
     * @return $this
     *
     * @throws GatewayException
     */
    public function fromCode($shortCode)
    {
        return $this->toCode($shortCode);
    }

    /**
     * Setup the keyword to be used.
     *
     * @param $keyword
     *
     * @return $this
     *
     * @throws GatewayException
     */
    public function usingKeyword($keyword)
    {
        if (! strlen($keyword)) {
            throw new GatewayException('Please enter a valid keyword.');
        }

        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Send the subscription request.
     *
     * @return array|mixed
     */
    public function send()
    {
        if ($this->subscribe) {
            $this->getCheckoutToken();

            return $this->sendRequest($this->config->getSubscriptionURL('/create'), $this->setupParameters());
        }

        return $this->sendRequest($this->config->getSubscriptionURL('/delete'), $this->setupParameters());
    }

    /**
     * Generate a request token for the transaction.
     *
     * @throws GatewayException
     */
    private function getCheckoutToken()
    {
        $response = $this->sendRequest($this->config->getTokenURL(), [
            'phoneNumber' => $this->mobile
        ]);

        if (strtolower($response->description) !== 'success') {
            throw new GatewayException($response->description);
        }

        $this->token = $response->token;
    }

    /**
     * Setup the request parameters.
     *
     * @return array
     */
    private function setupParameters()
    {
        return [
            'username'      => $this->config->username,
            'phoneNumber'   => $this->mobile,
            'shortCode'     => $this->shortCode,
            'keyword'       => $this->keyword,
            'checkoutToken' => $this->token,
        ];
    }

    public function getSubscriptions($shortCode, $keyword, $lastReceived = 0)
    {
        if (! strlen($shortCode)) {
            throw new GatewayException('Please enter a short code.');
        }
        if (! strlen($keyword)) {
            throw new GatewayException('Please enter a valid keyword.');
        }

        return $this->sendRequest($this->config->getSubscriptionURL(), [
            'username'      => $this->config->username,
            'shortCode'     => $shortCode,
            'keyword'       => $keyword,
            'lastReceivedId' => $lastReceived,
        ], 'GET');
    }
}
