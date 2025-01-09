<?php

$app = \SimpleFramework\App::getInstance();
$request = $app->getRequest();
$response = $app->getResponse();

$data = $request->json();

if( !isset($data['username']) || !isset($data['password']))
{
  $response->setStatusCode(400)
    ->json(['error' => 'Username and password are required'])
    ->send();
}

if( !$app->getUser()->register($data['username'], $data['password']))
{
  $response->setStatusCode(400)
    ->json(['error' => $app->getCaptions()->get('register.error')])
    ->send();
}

$response->json(['success' => true])->send();
