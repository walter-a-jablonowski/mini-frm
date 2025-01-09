<?php

// namespace App;

require_once __DIR__ . '/vendor/autoload.php';

use SimpleFramework\App;

// Initialize the application
$app = App::getInstance();

// Register routes
$router = $app->getRouter();

// Auth routes
$router->add('auth', 'App\\Pages\\Auth\\AuthController', 'login');
$router->add('auth/register', 'App\\Pages\\Auth\\AuthController', 'register');

// Index route
$router->add('index', 'App\\Pages\\Index\\IndexController', 'index');

// Run the application
$app->run();