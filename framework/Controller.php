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
    error_log("Rendering view: $view");
    
    $page = $this->app->getRequest()->get('page') ?? 'index';
    $viewPath = sprintf('%s/pages/%s/view/%s.php', 
      dirname(__DIR__),
      $page,
      $view
    );

    error_log("View path: $viewPath");

    if( !file_exists($viewPath))
    {
      error_log("View not found: $viewPath");
      throw new \RuntimeException("View not found: {$viewPath}");
    }

    extract($data);
    
    error_log("Starting view render");
    ob_start();
    require $viewPath;
    $content = ob_get_clean();
    error_log("View render complete");
    
    return $content;
  }

  protected function json(array $data): void
  {
    $this->app->getResponse()
      ->json($data)
      ->send();
  }
}
