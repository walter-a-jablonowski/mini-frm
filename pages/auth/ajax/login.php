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

if( !$app->getUser()->login($data['username'], $data['password']))
{
  $response->setStatusCode(401)
    ->json(['error' => $app->getCaptions()->get('login.error')])
    ->send();
}

$response->json(['success' => true])->send();
