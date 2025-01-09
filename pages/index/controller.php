<?php

namespace App\Pages\Index;

use SimpleFramework\Controller;

class IndexController extends Controller
{
  public function renderPage(): string  // TASK: maybe rename this
  {
    // currently in App

    // if( ! $this->app->getUser()->isLoggedIn())
    // {
    //   $this->app->getResponse()->redirect('?page=auth&action=login');
    //   return '';
    // }

    return $this->render('-this', [
      'captions' => $this->app->getCaptions(),
      'app' => $this->app
    ]);
  }

  public function logout() : void
  {
    $this->app->getUser()->logout();
    $this->app->getResponse()->json(['success' => true])->send();

    // TASK: maybe unneeded
    
    // $this->app->getUser()->logout();
    // $this->app->getResponse()->redirect('?page=auth&action=login');
  }
}
