<?php

require_once __DIR__ . '/vendor/autoload.php';

use SimpleFramework\App;

// Initialize the application
$app = App::getInstance();

// Register routes
$router = $app->getRouter();

// Auth routes
$router->add('auth', 'App\\Pages\\Auth\\AuthController', 'renderLogin');
$router->add('auth/login', 'App\\Pages\\Auth\\AuthController', 'renderLogin');
$router->add('auth/register', 'App\\Pages\\Auth\\AuthController', 'renderRegister');

// Index route
$router->add('index', 'App\\Pages\\Index\\IndexController', 'render');

// Run the application
$app->run();
