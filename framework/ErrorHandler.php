<?php

namespace SimpleFramework;

class ErrorHandler
{
  public function register(): void
  {
    set_error_handler([$this, 'handleError']);
    set_exception_handler([$this, 'handleException']);
  }

  public function handle(\Throwable $e): void
  {
    $this->handleException($e);
  }

  public function handleError(
    int $errno, 
    string $errstr, 
    string $errfile = '', 
    int $errline = 0
  ): bool
  {
    if( !(error_reporting() & $errno))
      return false;

    throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
  }

  public function handleException(\Throwable $e): void
  {
    $app = App::getInstance();
    $request = $app->getRequest();
    $response = $app->getResponse();

    if( $request->isAjax())
    {
      $response->setStatusCode(500)
        ->json([
          'error' => $e->getMessage(),
          'file' => $e->getFile(),
          'line' => $e->getLine()
        ])
        ->send();
    }
    else
    {
      $response->setStatusCode(500)
        ->setContent($this->renderErrorPage($e))
        ->send();
    }
  }

  private function renderErrorPage(\Throwable $e): string
  {
    ob_start();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <title>Error</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
      <div class="container mt-5">
        <div class="alert alert-danger">
          <h4 class="alert-heading">An error occurred</h4>
          <p><?= htmlspecialchars($e->getMessage()) ?></p>
          <?php if( App::getInstance()->getConfig()->get('debug')): ?>
            <hr>
            <p class="mb-0">File: <?= htmlspecialchars($e->getFile()) ?></p>
            <p class="mb-0">Line: <?= $e->getLine() ?></p>
          <?php endif ?>
        </div>
      </div>
    </body>
    </html>
    <?php
    return ob_get_clean();
  }
}
