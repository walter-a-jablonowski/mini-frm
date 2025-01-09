<?php
namespace App\Pages\Index;

use SimpleFramework\App;

class IndexController
{
  private App $app;

  public function __construct()
  {
    $this->app = App::getInstance();
  }

  public function index()
  {
    $app = $this->app;
    $captions = $app->getCaptions();
    
    ob_start();
    include __DIR__ . '/view.php';
    return ob_get_clean();
  }

  public function logout(): void
  {
    $this->app->getUser()->logout();
    $this->app->getResponse()->redirect('?page=auth&action=login');
  }
}
