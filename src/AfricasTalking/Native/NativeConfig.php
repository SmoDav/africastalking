<?php

namespace SmoDav\AfricasTalking\Native;

use SmoDav\AfricasTalking\Contracts\ConfigurationStore;

/**
 * Class NativeConfig
 *
 * @category PHP
 *
 * @author   David Mjomba <smodavprivate@gmail.com>
 */
class NativeConfig implements ConfigurationStore
{
    /**
     * Mpesa configuration file.
     *
     * @var array
     */
    protected $config;

    /**
     * NativeConfig constructor.
     *
     * @param string $userConfig
     */
    public function __construct($userConfig = __DIR__ . '/../../../../../../config/africastalking.php')
    {
        $defaultConfig = require __DIR__ . '/../../../config/africastalking.php';
        $custom        = [];
        if (\is_file($userConfig)) {
            $custom = require $userConfig;
        }

        $this->config = \array_merge($defaultConfig, $custom);
    }

    /**
     * Get the configuration value.
     *
     * @param      $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        $itemKey = \explode('.', $key)[1];

        if (isset($this->config[$itemKey])) {
            return $this->config[$itemKey];
        }

        return $default;
    }
}
