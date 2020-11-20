<?php

// Defines Directories
define('WEB_ROOT', __DIR__);
define('APP_ROOT', dirname(__DIR__) . '/eliteminingrepair');

// Composer Autoload
require_once APP_ROOT . '/vendor/autoload.php';

// PHP Dev Server
if (PHP_SAPI == 'cli-server') {
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

// Load .env File
$dotenv = \Dotenv\Dotenv::create(APP_ROOT);
$dotenv->load();

// Set Default Timezone
date_default_timezone_set(getenv('APP_TIMEZONE'));

// Start Session If Not Started
if (session_id() == '') {
    session_start();
}

// Slim Framework Settings
$settings = require_once APP_ROOT . '/src/settings.php';

// Init Slim Framework
$app = new \Slim\App($settings);

// Dependencies
require_once APP_ROOT . '/src/dependencies.php';

// Routes
require_once APP_ROOT . '/src/routes.php';

// Run It!
$app->run();
