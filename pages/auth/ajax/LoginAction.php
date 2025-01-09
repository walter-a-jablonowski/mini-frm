<?php

namespace App\Pages\Auth;

use SimpleFramework\User;

trait LoginAction
{
  public function login(): void
  {
    error_log("LoginAction: Starting login process");
    $request = $this->app->getRequest();
    $response = $this->app->getResponse();
    $data = $request->json();

    if( ! isset($data['username']) || ! isset($data['password']))
    {
      error_log("LoginAction: Missing username or password");
      $response->setStatusCode(400)
        ->json(['error' => 'Username and password are required'])
        ->send();
    }

    try 
    {
      error_log("LoginAction: Creating user object for username: " . $data['username']);
      $user = new User('username', $data['username']);
      
      if( ! $user->login($data['username'], $data['password']))
      {
        error_log("LoginAction: Login failed for user: " . $data['username']);
        throw new \RuntimeException('Invalid credentials');
      }
      
      error_log("LoginAction: Login successful for user: " . $data['username']);
      $response->json(['success' => true])->send();
    }
    catch(\RuntimeException $e)
    {
      error_log("LoginAction: Exception during login: " . $e->getMessage());
      $response->setStatusCode(401)
        ->json(['error' => $this->app->getCaptions()->get('login.error')])
        ->send();
    }
  }
}
