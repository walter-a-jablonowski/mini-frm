<?php

$app = \SimpleFramework\App::getInstance();
$request = $app->getRequest();
$response = $app->getResponse();

$data = $request->json();
error_log("Login attempt - Request data: " . print_r($data, true));

if( !isset($data['username']) || !isset($data['password']))
{
  error_log("Login failed - Missing username or password");
  $response->setStatusCode(400)
    ->json(['error' => 'Username and password are required'])
    ->send();
}

$user = $app->getUser();
$result = $user->login($data['username'], $data['password']);
error_log("Login attempt result: " . ($result ? 'success' : 'failed') . " for user: " . $data['username']);

if( !$result)
{
  error_log("Login failed - Invalid credentials");
  $response->setStatusCode(401)
    ->json(['error' => $app->getCaptions()->get('login.error')])
    ->send();
}

error_log("Login successful - User: " . $data['username']);
$response->json(['success' => true])->send();
