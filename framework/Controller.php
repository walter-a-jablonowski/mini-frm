<?php

namespace SimpleFramework;

class Controller
{
  protected App $app;

  public function __construct()
  {
    $this->app = App::getInstance();
  }

  protected function render(string $view, array $data = []): string
  {
    $page = $this->app->getRequest()->get('page') ?? 'index';
    $viewPath = sprintf('%s/pages/%s/view/%s.php', 
      dirname(__DIR__),
      $page,
      $view
    );

    if( ! file_exists($viewPath))
      throw new \RuntimeException("View not found: {$viewPath}");

    extract($data);
    
    ob_start();
    require $viewPath;
    $content = ob_get_clean();
    
    return $content;
  }

  protected function json(array $data): void
  {
    $this->app->getResponse()
      ->json($data)
      ->send();
  }
}
