<?php

use Dotenv\Dotenv;
use Phalcon\Loader;
use function Gewaer\Core\appPath;

// Register the auto loader
require __DIR__ . '/functions.php';

$loader = new Loader();
$namespaces = [
    'Niden' => appPath('/library'),
    'Gewaer' => appPath('/library'),
    'Gewaer\Api\Controllers' => appPath('/api/controllers'),
    'Gewaer\Cli\Tasks' => appPath('/cli/tasks'),
    'Niden\Tests' => appPath('/tests'),
    'Gewaer\Tests' => appPath('/tests'),
    'Gewaer\Contracts' => appPath('/library/Contracts'),
    'Gewaer\Handlers' => appPath('/library/Handlers'),
    'Gewaer\Notifications\PushNotifications' => appPath('/library/Notifications/PushNotifications/')
];

$loader->registerNamespaces($namespaces);

$loader->register();

/**
 * Composer Autoloader
 */
require appPath('/vendor/autoload.php');

// Load environment
(new Dotenv(appPath()))->overload();
