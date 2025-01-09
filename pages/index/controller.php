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

  public function logout(): void
  {
    // TASK: maybe unneeded, but we also have a fwd in js

    // if( $this->app->getRequest()->isAjax())
    // {
    //   $this->app->getUser()->logout();
    //   $this->app->getResponse()
    //     ->json(['success' => true])
    //     ->send();
    // }
    
    $this->app->getUser()->logout();
    $this->app->getResponse()->redirect('?page=auth&action=login');
  }
}
