<?php
declare(strict_types = 1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Routing\RouteContext;

class HomeController extends Controller
{
    public function home(Request $request, Response $response)
    {
        $this->container->get(LoggerInterface::class)->debug(HomeController::class, ['message' => "Ejecución de función Home"]);
        $response->getBody()->write('Cualquier cosa');
        return $response;
    }

}