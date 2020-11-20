<?php

// Namespace
namespace Elite\Middleware;

// Use Libs
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// GoogleAnalytics
class GoogleAnalytics extends \Elite\Middleware\Middleware
{

    public function __invoke(Request $request, Response $response, $next)
    {
        // Google Analytics ID
        $gAnal = getenv('G_ANALYTICS');

        // Global Google {{ analytics }}
        $this->container->view->getEnvironment()->addGlobal("analytics", "<script async 
src='https://www.googletagmanager.com/gtag/js?id=".$gAnal."'></script> <script> 
window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} 
gtag('js', new Date()); gtag('config', '".$gAnal."'); </script>");

        // Return Response
        $response = $next($request, $response);
        return $response;
    }

}
