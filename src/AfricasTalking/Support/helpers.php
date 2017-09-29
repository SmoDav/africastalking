<?php

use SmoDav\AfricasTalking\Config\Config;
use SmoDav\AfricasTalking\Engine\Mailman;

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
