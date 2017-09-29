<?php

namespace SmoDav\AfricasTalking\Support;

use Composer\Script\Event;

class Installer
{
    public static function install(Event $event)
    {
        $config    = __DIR__ . '/../../../config/africastalking.php';
        $configDir = self::getConfigDirectory($event);

        if (! \is_file($configDir . '/africastalking.php')) {
            \copy($config, $configDir . '/africastalking.php');
        }
    }

    public static function getConfigDirectory(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $configDir = $vendorDir . '/../config';

        if (! \is_dir($configDir)) {
            \mkdir($configDir, 0755, true);
        }

        return $configDir;
    }
}
