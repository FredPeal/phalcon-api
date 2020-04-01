<?php

use Dotenv\Dotenv;
use Phalcon\Loader;
use function Canvas\Core\appPath;

$loader = new Loader();
$namespaces = [
    'Canvas' => '/canvas-core/src',
    'Canvas\Cli' => '/canvas-core/src/Cli',
    'Baka\Auth' => '/baka/auth/src',
    'Baka\Database' => '/baka/database/src',
    'Baka\Elasticsearch' => '/baka/elasticsearch/src',
    'Baka\Http' => '/baka/http/src',
    'Phalcon\Cashier' => '/baka/cashier/src',
    'Baka\Mail' => '/baka/mail/src',
    'Baka\Blameable' => '/baka/blameable/src',
    'Baka\Support' => '/baka/support/src',
    'Baka\Router' => '/baka/router/src'
];

$loader->registerNamespaces($namespaces);

$loader->register();
/**
 * Composer Autoloader.
 */
require appPath('vendor/autoload.php');

// Load environment
(new Dotenv(appPath()))->overload();
