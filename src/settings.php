<?php

// Get Debug Mode From ENV
$dbug = getenv('APP_DEBUG');

if ('yes' == $dbug) {
    $dmode = true;
} else {
    $dmode = false;
}

// Return Settings
return [
    'settings' => [
        'debug' => $dmode,
        'displayErrorDetails' => $dmode,
        'addContentLengthHeader' => false,
        'determineRouteBeforeAppMiddleware' => true,
        'routerCacheFile' => false,
    ],
];
