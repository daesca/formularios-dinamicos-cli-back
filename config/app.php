<?php

use Slim\Factory\AppFactory;
use DI\Container;

require_once dirname(__DIR__) . "/vendor/autoload.php";

$container = new Container();

$settings = require_once __DIR__ . "/settings.php";
$settings($container);

$logger = require_once __DIR__ . "/logger.php";
$logger($container);


$connections = require_once __DIR__. "/connection.php";
$connections($container);


AppFactory::setContainer($container);

$app = AppFactory::create();

$middlewares = require_once __DIR__ . "/middleware.php";
$middlewares($app);

$controllers = require_once __DIR__ . "/controllers.php";
$controllers($app);

$routes = require_once dirname(__DIR__) . "/src/routes.php";

$container->set("routeParser", function () use ($app) {
   return $app->getRouteCollector()->getRouteParser();
});
$routes($app);

$app->run();