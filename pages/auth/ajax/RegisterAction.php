<?php

namespace App\Pages\Auth;

use SimpleFramework\User;

trait RegisterAction
{
  public function register(): void
  {
    $request  = $this->app->getRequest();
    $response = $this->app->getResponse();
    $data     = $request->json();

    if( ! isset($data['username']) || ! isset($data['password']))
    {
      $response->setStatusCode(400)
        ->json(['error' => 'Username and password are required'])
        ->send();
    }

    $user = new User($this->app->getSession(), 'username', $data['username']);
    
    if( ! $user || ! $user->register($this->app->getSession(), $data['username'], $data['password']))
    {
      $response->setStatusCode(400)
        ->json(['error' => $this->app->getCaptions()->get('register.error')])
        ->send();
    }

    $response->json(['success' => true])->send();
  }
}
