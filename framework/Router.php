<?php

namespace SimpleFramework;

class Router
{
  private array $routes = [];
  private array $beforeMiddleware = [];
  private array $afterMiddleware = [];

  public function add(string $page, string $controller, string $action): void
  {
    $this->routes[$page] = [
      'controller' => $controller,
      'action' => $action
    ];
  }

  public function before(callable $middleware): void
  {
    $this->beforeMiddleware[] = $middleware;
  }

  public function after(callable $middleware): void
  {
    $this->afterMiddleware[] = $middleware;
  }

  public function dispatch(Request $request): string
  {
    $page   = $request->get('page') ?? 'index';
    $action = $request->get('action') ?? null;

    if( $action !== null)
      $page = $page . '/' . $action;

    if( ! isset($this->routes[$page]))
      throw new \RuntimeException("Page not found: {$page}");

    $route = $this->routes[$page];
    $controllerClass = $route['controller'];
    $action = $route['action'];

    if( ! class_exists($controllerClass))
      throw new \RuntimeException("Controller not found: {$controllerClass}");

    $controller = new $controllerClass();
    
    if( ! method_exists($controller, $action))
      throw new \RuntimeException("Action not found: {$action}");

    foreach($this->beforeMiddleware as $middleware)
      $middleware($request);

    $content = $controller->$action();

    foreach($this->afterMiddleware as $middleware)
      $middleware($request);

    if( ! is_string($content))
      throw new \RuntimeException("Controller action must return a string");

    return $content;
  }
}
