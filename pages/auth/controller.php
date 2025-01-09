<?php

namespace App\Pages\Auth;

use SimpleFramework\Controller;

class AuthController extends Controller
{
  public function login(): string
  {
    if( $this->app->getUser()->isLoggedIn())
      header('Location: ?page=index');

    return $this->render('login', [
      'captions' => $this->app->getCaptions()->get('login')
    ]);
  }

  public function register(): string
  {
    if( $this->app->getUser()->isLoggedIn())
      header('Location: ?page=index');

    return $this->render('register', [
      'captions' => $this->app->getCaptions()->get('register')
    ]);
  }
}
