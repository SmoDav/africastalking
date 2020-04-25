<?php

use SmoDav\AfricasTalking\Engine\Runner;

if (!function_exists('sms')) {
    function sms(array $numbers = [], string $message = null, int $from = null, bool $enqueue = false)
    {
        if (func_num_args() === 0) {
            return Runner::instance()->sms();
        }

        return Runner::instance()->sms()->send([
            'enqueue' => $enqueue,
            'from' => $from,
            'message' => $message,
            'to' => $numbers,
        ]);
    }
}

if (!function_exists('fetchSms')) {
    function fetchSms(int $lastReceivedId = 0)
    {
        return Runner::instance()->sms()->fetchMessages(['lastReceivedId' => $lastReceivedId]);
    }
}

if (!function_exists('subscribeMobile')) {
    function subscribeMobile(string $mobile, int $shortCode, string $keyword)
    {
        $token = Runner::instance()->token()->createCheckoutToken(['phoneNumber' => $mobile]);

        return Runner::instance()->sms()->createSubscription([
            'shortCode' => $shortCode,
            'keyword' => $keyword,
            'phoneNumber' => $mobile,
            'checkoutToken' => $token['data']->token,
        ]);
    }
}

if (!function_exists('subscriptions')) {
    function subscriptions(int $shortCode, string $keyword, int $lastReceivedId = 0)
    {
        return Runner::instance()->sms()->fetchSubscriptions([
            'shortCode' => $shortCode,
            'keyword' => $keyword,
            'lastReceivedId' => $lastReceivedId,
        ]);
    }
}

if (!function_exists('unsubscribeMobile')) {
    function unsubscribeMobile(string $mobile, int $shortCode, string $keyword)
    {
        return Runner::instance()->sms()->deleteSubscription([
            'shortCode' => $shortCode,
            'keyword' => $keyword,
            'phoneNumber' => $mobile,
        ]);
    }
}
