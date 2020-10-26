<?php

// Use Libs
use \Psr\Container\ContainerInterface as Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/*
 * NOT FOUND
**/

// Override Default Not Found Handler
unset($app->getContainer()['notFoundHandler']);

/** *********************************************
$app->getContainer()['notFoundHandler'] = function (Container $container) {
    return function (Request $request, Response $response) use ($container) {
        $response = new \Slim\Http\Response(404);
        $data = [
            'error' => 'Error 404 - Not Found!',
        ];
        $response = $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
        return $container->view->render($response, 'error.twig', $data);
    };
};
********************************************* **/

// Set New Not Found Handler
$app->getContainer()['notFoundHandler'] = function (Container $container) {
    return function (Request $request, Response $response) use ($container) {

        // 404 Error
        $response = new \Slim\Http\Response(404);

        /** *********************************************************
        $response = $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
        return $container->view->render($response, 'error.twig', [
            'status' => 'error',
            'code' => '404',
        ]);
        ********************************************************* **/

        // Get Visitor IP
        $whip = new \Vectorface\Whip\Whip();
        $whip->setSource($request);
        $ip = $whip->getValidIpAddress();

        // Method
        $method = $request->getMethod();

        // Path (URL)
        $path = $request->getUri()->getPath();

        // URL Params
        $params = $request->getParams();

        // Data Array
        $logData = [
            'Error' => '404',
            'IP' => $ip,
            'Method' => $method,
            'Path' => $path,
            'Params' => $params,
        ];

        // Log Info
        $logger = $container->get('logger');
        $logger->debug('ERROR', $logData);

        $data = [
            'status' => 'error',
            'code' => '404',
            'message' => 'Not Found',
        ];

        // Return JSON
        return $response->withJson($data);
    };
};

/*
 * NOT ALLOWED
**/

unset($app->getContainer()['notAllowedHandler']);

$app->getContainer()['notAllowedHandler'] = function (Container $container) {
    return function (Request $request, Response $response, $methods) use ($container) {
        $data = [
            'status' => 'error',
            'code' => '405',
            'message' => $response->withStatus(405)->getReasonPhrase().', Method must be one of: '.implode(', ', $methods),
        ];

        return $response->withStatus(405)->withJson($data);
    };
};

/*
 * Error Handler
**/

unset($app->getContainer()['errorHandler']);

$app->getContainer()['errorHandler'] = function (Container $container) {
    return function (Request $request, Response $response, $exception) use ($container) {
        $response->getBody()->rewind();

        $data = [
            'status' => 'error',
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => explode("\n", $exception->getTraceAsString()),
        ];

        return $response->withStatus(500)->withJson($data);
    };
};

/*
 * PHP 7+ Error Handler
**/

unset($app->getContainer()['phpErrorHandler']);

$app->getContainer()['phpErrorHandler'] = function (Container $container) {
    return $container['errorHandler'];
};
