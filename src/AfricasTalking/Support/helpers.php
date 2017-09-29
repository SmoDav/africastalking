<?php

use SmoDav\AfricasTalking\Config\Config;
use SmoDav\AfricasTalking\Engine\Mailman;
use SmoDav\AfricasTalking\Engine\Subscriber;

function sms($to, $message, $from = null, $options = [], $bulkMode = true)
{
    if (! $config = Config::$instance) {
        if (! function_exists('app')) {
            throw new Exception('You need to instantiate the configuration first');
        }

        $config = app()->make(Config::class);
    }

    $mailman = new Mailman($config);
    $mailman = $mailman->to($to)->message($message)->from($from)->withOptions($options);

    if (! $bulkMode) {
        $mailman->inSingleMode();
    }

    return $mailman->send();
}

function fetchSms($lastFetchedId = 0)
{
    if (! $config = Config::$instance) {
        if (! function_exists('app')) {
            throw new Exception('You need to instantiate the configuration first');
        }

        $config = app()->make(Config::class);
    }

    return (new Mailman($config))->fetch($lastFetchedId);
}

function subscribeMobile($mobile, $shortCode, $keyword)
{
    if (! $config = Config::$instance) {
        if (! function_exists('app')) {
            throw new Exception('You need to instantiate the configuration first');
        }

        $config = app()->make(Config::class);
    }

    return (new Subscriber($config))
        ->subscribe($mobile)
        ->toCode($shortCode)
        ->usingKeyword($keyword)
        ->send();
}

function unsubscribeMobile($mobile, $shortCode, $keyword)
{
    if (! $config = Config::$instance) {
        if (! function_exists('app')) {
            throw new Exception('You need to instantiate the configuration first');
        }

        $config = app()->make(Config::class);
    }

    return (new Subscriber($config))
        ->unsubscribe($mobile)
        ->toCode($shortCode)
        ->usingKeyword($keyword)
        ->send();
}

function subscriptions($shortCode, $keyword, $lastReceived = 0)
{
    if (! $config = Config::$instance) {
        if (! function_exists('app')) {
            throw new Exception('You need to instantiate the configuration first');
        }

        $config = app()->make(Config::class);
    }

    return (new Subscriber($config))
        ->getSubscriptions($shortCode, $keyword, $lastReceived);
}
