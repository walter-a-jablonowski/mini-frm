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

if( ! $handler)
{
  $app->getResponse()
    ->setStatusCode(400)
    ->json(['error' => 'No handler specified'])
    ->send();
}

$handlerPath = sprintf('%s/pages/%s/ajax/%s.php', 
  __DIR__,
  $request->get('page'),
  $handler
);

if( ! file_exists($handlerPath))
{
  $app->getResponse()
    ->setStatusCode(404)
    ->json(['error' => 'Handler not found'])
    ->send();
}

require_once $handlerPath;
