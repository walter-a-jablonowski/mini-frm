<?php

namespace SimpleFramework;

class Router
{
  private array $routes = [];
  private array $beforeMiddleware = [];
  private array $afterMiddleware = [];

  public function add(string $page, string $controller, string $action): void
  {
    error_log("Adding route - Page: $page, Controller: $controller, Action: $action");
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
    $page = $request->get('page') ?? 'index';
    $action = $request->get('action') ?? null;

    error_log("Dispatching - Page: $page, Action: " . ($action ?? 'none'));

    if( $action !== null)
      $page = $page . '/' . $action;

    error_log("Looking for route: $page");
    error_log("Available routes: " . print_r($this->routes, true));

    if( !isset($this->routes[$page]))
    {
      error_log("Route not found: $page");
      throw new \RuntimeException("Page not found: {$page}");
    }

    $route = $this->routes[$page];
    $controllerClass = $route['controller'];
    $action = $route['action'];

    error_log("Loading controller: $controllerClass");

    if( !class_exists($controllerClass))
    {
      error_log("Controller not found: $controllerClass");
      throw new \RuntimeException("Controller not found: {$controllerClass}");
    }

    $controller = new $controllerClass();
    
    error_log("Checking action: $action");
    
    if( !method_exists($controller, $action))
    {
      error_log("Action not found: $action in $controllerClass");
      throw new \RuntimeException("Action not found: {$action}");
    }

    foreach($this->beforeMiddleware as $middleware)
      $middleware($request);

    $content = $controller->$action();

    foreach($this->afterMiddleware as $middleware)
      $middleware($request);

    if( !is_string($content))
      throw new \RuntimeException("Controller action must return a string");

    return $content;
  }
}
