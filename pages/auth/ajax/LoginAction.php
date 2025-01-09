<?php

namespace App\Pages\Auth;

use SimpleFramework\User;

trait LoginAction
{
  public function login(): void
  {
    $request = $this->app->getRequest();
    $response = $this->app->getResponse();
    $data = $request->json();

    if( ! isset($data['username']) || ! isset($data['password']))
    {
      $response->setStatusCode(400)
        ->json(['error' => 'Username and password are required'])
        ->send();
    }

    try 
    {
      $user = new User('username', $data['username']);
      
      if( ! $user->login($data['username'], $data['password']))
      {
        throw new \RuntimeException('Invalid credentials');
      }
      
      $response->json(['success' => true])->send();
    }
    catch(\RuntimeException $e)
    {
      $response->setStatusCode(401)
        ->json(['error' => $this->app->getCaptions()->get('login.error')])
        ->send();
    }
  }
}
