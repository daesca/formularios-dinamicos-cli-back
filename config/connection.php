<?php

declare(strict_types=1);

use DI\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

return function (Container $container) {
    $settings = $container->get('settings')['connection'];
    $capsule = new Capsule;

    $capsule->addConnection([
        'driver' => $settings['driver'],
        'host' => $settings['host'],
        'database' => $settings['dbname'],
        'username' => $settings['dbuser'],
        'password' => $settings['dbpass'],
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    $container->set('db', function () use ($capsule, $container) {
        return $capsule;
    });
};