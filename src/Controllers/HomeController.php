<?php

// Namespace
namespace Elite\Controllers;

// Use Libs
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// HomeController
class HomeController extends \Elite\Controllers\Controller
{
    // Main Route
    public function index(Request $request, Response $response, array $args)
    {

        // Debug Mode
        if (getenv('APP_DEBUG') == 'yes') {
            // Flash Message
            $this->flash->addMessageNow('info', 'Debug Mode Enabled!');
            // Enable Debug Mode
            $debugMode = 'yes';
            dump($_SERVER);
            dump($_SESSION);
        } else {
            $debugMode = 'no';
        }

        // Array For Errors
        $errors = [];

        // Params
        $params = $request->getParams();

        // Cookie Params
        $cParams = $request->getCookieParams();

        // Query Params
        $qParams = $request->getQueryParams();

        // Render View
        return $this->view->render($response, 'home.twig', [
            'debugMode' => $debugMode,
            'errors' => $errors,
            'params' => $params,
            'cookieParams' => $cParams,
            'qParams' => $qParams,
        ]);
    }
}
