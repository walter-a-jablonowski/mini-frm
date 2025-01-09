<?php

namespace App\Pages\Auth;

trait LoginAction
{
  public function login(): void
  {
    $request = $this->app->getRequest();
    $response = $this->app->getResponse();
    $data = $request->json();

    if( ! isset($data['username']) || !isset($data['password']))
    {
      $response->setStatusCode(400)
        ->json(['error' => 'Username and password are required'])
        ->send();
    }

    $user = $this->app->getUser();
    $result = $user->login($data['username'], $data['password']);

    if( ! $result)
    {
      $response->setStatusCode(401)
        ->json(['error' => $this->app->getCaptions()->get('login.error')])
        ->send();
    }

    $response->json(['success' => true])->send();
  }
}
