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
    ob_start();
    include __DIR__ . '/view.php';
    return ob_get_clean();
  }
}
