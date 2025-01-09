<?php

require_once __DIR__ . '/vendor/autoload.php';

use SimpleFramework\App;

$app = App::getInstance();
$request = $app->getRequest();

if( ! $request->isAjax())
{
  $app->getResponse()
    ->setStatusCode(403)
    ->json(['error' => 'Only AJAX requests are allowed'])
    ->send();
}

$handler = $request->get('handler');
$page = $request->get('page');

if( ! $handler || ! $page)
{
  $app->getResponse()
    ->setStatusCode(400)
    ->json(['error' => 'Missing handler or page parameter'])
    ->send();
}

$controllerClass = sprintf('App\\Pages\\%s\\%sController', 
  ucfirst($page),
  ucfirst($page)
);

if( ! class_exists($controllerClass))
{
  $app->getResponse()
    ->setStatusCode(404)
    ->json(['error' => 'Controller missing'])
    ->send();
}

$controller = new $controllerClass();

if( ! method_exists($controller, $handler))
{
  $app->getResponse()
    ->setStatusCode(404)
    ->json(['error' => 'Handler missing'])
    ->send();
}

$controller->$handler();
