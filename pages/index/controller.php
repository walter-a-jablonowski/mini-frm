<?php

namespace App\Pages\Index;

use SimpleFramework\Controller;

class IndexController extends Controller
{
  public function render(string $view = '-this', array $data = []): string
  {
    // if( $this->app->isLoggedIn())
    //   $this->app->getResponse()->redirect('/auth');

    return parent::render($view, [
      'title' => $this->app->getCaptions()->get('index.title'),
      'captions' => $this->app->getCaptions(),
      'app' => $this->app
    ]);
  }

  public function logout(): void
  {
    $user = $this->app->getUser();
    if( $user)
    {
      $user->logout();
      $this->app->setCurrentUser(null);
    }

    $this->app->getResponse()
      ->json(['success' => true])
      ->send();
  }
}
