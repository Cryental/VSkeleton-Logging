<?php
if (!defined("LOGGING_START")) {
    return;
}

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

date_default_timezone_set($config['timezone'] ?? 'UTC');

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => $config['database']['driver'],
    'host' => $config['database']['host'],
    'database' => $config['database']['database'],
    'username' => $config['database']['username'],
    'password' => $config['database']['password'],
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();