<?php
declare(strict_types = 1);

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

abstract class Controller
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response)
    {
        return $response;
    }

    public function __get($name)
    {
        if ($this->container->get($name)) {
            return $this->container->get($name);
        }
        return null;
    }
}