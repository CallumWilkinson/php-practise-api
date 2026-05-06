<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

$isDebug = ($_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? '0') === '1';

if ($isDebug) {
    umask(0000);
}
