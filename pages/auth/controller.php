<?php

namespace App\Pages\Auth;

use SimpleFramework\Controller;
use App\Pages\Auth\LoginAction;
use App\Pages\Auth\RegisterAction;

class AuthController extends Controller
{
  use LoginAction;
  use RegisterAction;

  public function renderLogin(): void
  {
    if( $this->app->isLoggedIn())
    {
      $this->app->getResponse()
        ->redirect('/');
    }

    $content = $this->render('login', [
      'title' => $this->app->getCaptions()->get('login.title')
    ]);
    
    $this->app->getResponse()
      ->setContent($content)
      ->send();
  }

  public function renderRegister(): void
  {
    if( $this->app->isLoggedIn())
    {
      $this->app->getResponse()
        ->redirect('/');
    }

    $content = $this->render('register', [
      'title' => $this->app->getCaptions()->get('register.title')
    ]);
    
    $this->app->getResponse()
      ->setContent($content)
      ->send();
  }
}
