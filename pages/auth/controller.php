<?php

namespace App\Pages\Auth;

use SimpleFramework\Controller;
use App\Pages\Auth\LoginAction;
use App\Pages\Auth\RegisterAction;

class AuthController extends Controller
{
  use LoginAction;
  use RegisterAction;

  public function renderLogin() : string
  {
    if( $this->app->getUser()->isLoggedIn())
      header('Location: ?page=index');

    return $this->render('login', [
      'captions' => $this->app->getCaptions()->get('login')
    ]);
  }

  public function renderRegister() : string
  {
    if( $this->app->getUser()->isLoggedIn())
      header('Location: ?page=index');

    return $this->render('register', [
      'captions' => $this->app->getCaptions()->get('register')
    ]);
  }
}
