<?php

declare(strict_types=1);

use Slim\App;
use Selective\BasePath\BasePathMiddleware;

return function (App $app) {
    $settings = $app->getContainer()->get('settings');

    $app->add(new BasePathMiddleware($app));
    $app->addErrorMiddleware(
        $settings['displayErrorDetails'],
        $settings['logErrorDetails'],
        $settings['logErrors']);

};