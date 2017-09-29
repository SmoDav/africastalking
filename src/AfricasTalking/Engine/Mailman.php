<?php

namespace SmoDav\AfricasTalking\Engine;

use GuzzleHttp\Exception\RequestException;
use SmoDav\AfricasTalking\Config\Config;
use SmoDav\AfricasTalking\Exceptions\GatewayException;

/**
 * Class Mailman.
 *
 * @category PHP
 *
 * @author   David Mjomba <smodavprivate@gmail.com>
 */
class Mailman
{
    /**
     * @var string
     */
    protected $mobile;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $from;

    /**
     * @var bool
     */
    protected $bulkMode = true;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var Config
     */
    private $config;

    /**
     * Mailman constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Set the mobile numbers to send the message to separated by commas.
     *
     * @param $mobile
     *
     * @return $this
     *
     * @throws GatewayException
     */
    public function to($mobile)
    {
        if (strlen($mobile) < 10) {
            throw new GatewayException('Please enter a valid mobile number.');
        }

        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Set the message to be sent to the numbers.
     *
     * @param $message
     *
     * @return $this
     *
     * @throws GatewayException
     */
    public function message($message)
    {
        if (strlen($message) == 0) {
            throw new GatewayException('Please enter a valid message.');
        }

        $this->message = $message;

        return $this;
    }

    /**
     * Set the Short Code that should be used to send the message.
     *
     * @param null $from
     *
     * @return $this
     */
    public function from($from = null)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set whether its in bulk mode or in single mode. Only used when the Short Code is set.
     *
     * @return $this
     */
    public function inSingleMode()
    {
        $this->bulkMode = false;

        return $this;
    }

    /**
     * Set the additional options.
     *
     * @param array $options
     *
     * @return $this
     */
    public function withOptions($options = [])
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Sent the message to the numbers.
     *
     * @param $mobile
     * @param $message
     * @param null  $from
     * @param bool  $bulkMode
     * @param array $options
     *
     * @return array|mixed
     */
    public function send($mobile, $message, $from = null, $options = [], $bulkMode = true)
    {
        $this->to($mobile);
        $this->message($message);
        $this->from($from);
        $this->withOptions($options);
        if (! $bulkMode) {
            $this->inSingleMode();
        }

        return $this->sendRequest($this->config->getSMSUrl(), $this->setupParameters());
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
     * Setup the options to be sent with the request.
     *
     * @return array
     *
     * @throws GatewayException
     */
    protected function setupParameters()
    {
        $parameters = [
            'username' => $this->config->username,
            'to'       => $this->mobile,
            'message'  => $this->message,
        ];

        if ($this->from != null) {
            $parameters['from'] = $this->from;
            $parameters['bulkSMSMode'] = $this->bulkMode;
        }

        if (! count($this->options)) {
            return $parameters;
        }

        $allowedKeys = ['enqueue', 'keyword', 'linkId', 'retryDurationInHours'];

        foreach ($this->options as $key => $value) {
            if (in_array($key, $allowedKeys) && strlen($value)) {
                $parameters[$key] = $value;

                continue;
            }

            throw new GatewayException('Invalid option: ' . $key);
        }

        return $parameters;
    }

    /**
     * Fetch new messages from your Short Code.
     *
     * @param int $lastId
     *
     * @return array|mixed
     */
    public function fetch($lastId = 0)
    {
        $response = $this->sendRequest($this->config->getSMSUrl(), [
            'username' => $this->config->username,
            'lastReceivedId' => $lastId,
        ], 'GET');

        return $response->SMSMessageData->Messages;
    }
}
