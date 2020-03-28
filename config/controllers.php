<?php
declare(strict_types = 1);

use Slim\App;

return function (App $app) {

    $container = $app->getContainer();

    $container->set('HomeController', function () use ($container) {

        return new \App\Controllers\HomeController($container);

    });

    $container->set('CampaignController', function () use ($container) {

        return new \App\Controllers\CampaignController($container);

    });

};