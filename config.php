<?php

if (!defined('LOGGING_START')) {
    return;
}

$config = [
    'timezone' => 'UTC',
    'database' => [
        'driver'   => 'mysql',
        'host'     => '127.0.0.1',
        'database' => 'FrameworkLoggingDB',
        'username' => 'root',
        'password' => '123',
    ],
];
