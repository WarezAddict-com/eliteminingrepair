<?php

// Namespace
namespace Elite\Controllers;

// Use Libs
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// SearchController
class SearchController extends \Elite\Controllers\Controller
{
    // POST
    public function post(Request $request, Response $response, array $args)
    {
        // Debug Mode
        if (getenv('APP_DEBUG') == 'yes') {
            // Flash Message
            $this->flash->addMessageNow('info', 'Debug Mode Enabled!');
            // Enable Debug Mode
            $debugMode = 'yes';
            // Debug Info
            dump($_SERVER);
            dump($_SESSION);
        } else {
            // Disable Debug Mode
            $debugMode = 'no';
        }

        // Array For Errors
        $errors = [];

        // Query
        $query = filter_var($_POST['query'], FILTER_SANITIZE_STRING);

        // Render View
        return $this->view->render($response, 'search.twig', [
            'debugMode' => $debugMode,
            'errors' => $errors,
            'query' => $query,
        ]);
    }

    public function get(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'search.twig', [
            'debugMode' => 'yes'
        ]);
    }
}
