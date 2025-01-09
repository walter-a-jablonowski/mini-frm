<?php

namespace App\Pages\Auth;

use SimpleFramework\Controller;

class AuthController extends Controller
{
  public function login()
  {
    if( $this->app->getUser()->isLoggedIn())
      header('Location: ?page=index');

    $this->render('login', [
      'captions' => $this->app->getCaptions()->get('login')
    ]);
  }

  public function register()
  {
    if( $this->app->getUser()->isLoggedIn())
      header('Location: ?page=index');

    $this->render('register', [
      'captions' => $this->app->getCaptions()->get('register')
    ]);
  }
}
