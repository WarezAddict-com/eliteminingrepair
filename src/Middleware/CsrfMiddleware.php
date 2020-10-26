<?php

// Namespace
namespace Elite\Middleware;

// Use Libs
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// CsrfViewMiddleware
class CsrfMiddleware extends \Elite\Middleware\Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        // CSRF HTML Helper
        $this->container->view->getEnvironment()->addGlobal('csrf', '<input type="hidden" name="'.$this->container->csrf->getTokenNameKey().'" value="'.$this->container->csrf->getTokenName().'"><input type="hidden" name="'.$this->container->csrf->getTokenValueKey().'" value="'.$this->container->csrf->getTokenValue().'">');

        // Return
        $response = $next($request, $response);
        return $response;
    }
}
