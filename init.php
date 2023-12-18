<?php

if (!defined('LOGGING_START')) {
    return;
}

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/config.php';

date_default_timezone_set($config['timezone'] ?? 'UTC');

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Pagination\Paginator;

Flight::register('db', 'PDO', array('mysql:host=hostingmysql299.nominalia.com;dbname=budainteractiu', 'F538317_budafilm', '@Buda#Int2015'), function ($db) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});

$capsule = new Capsule();

$capsule->addConnection([
    'driver'   => $config['database']['driver'],
    'host'     => $config['database']['host'],
    'database' => $config['database']['database'],
    'username' => $config['database']['username'],
    'password' => $config['database']['password'],
]);

Paginator::currentPageResolver(function ($pageName = 'page') {
    return (int) ($_GET[$pageName] ?? 1);
});

$capsule->setAsGlobal();
$capsule->bootEloquent();
