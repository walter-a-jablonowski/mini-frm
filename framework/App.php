<?php

namespace SimpleFramework;

class App
{
  private static ?App $instance = null;
  private static bool $initializing = false;
  
  private Config $config;
  private Router $router;
  private Request $request;
  private Response $response;
  private Session $session;
  private User $user;
  private ErrorHandler $errorHandler;
  private Captions $captions;

  private function __construct()
  {
    if( self::$initializing)
      throw new \RuntimeException("Circular dependency detected during initialization");
      
    self::$initializing = true;
    $this->initializeComponents();
    self::$initializing = false;
  }

  public static function getInstance(): App
  {
    if( self::$instance === null)
    {
      if( self::$initializing)
        throw new \RuntimeException("Circular dependency detected: Cannot get App instance during initialization");
        
      self::$instance = new self();
    }
    
    return self::$instance;
  }

  private function initializeComponents(): void
  {
    try 
    {
      // Initialize core components first that don't depend on others
      $this->config = new Config();
      $this->errorHandler = new ErrorHandler();
      $this->session = new Session();
      $this->request = new Request();
      $this->response = new Response();
      
      // Then initialize components that may need the core ones
      $this->router = new Router();
      $this->captions = new Captions();
      
      // Initialize user last since it depends on session
      $this->user = new User($this->session);
      
    }
    catch (\Throwable $e) {
      throw $e;
    }
  }

  public function run(): void
  {
    try 
    {
      // Check authentication and redirect if needed
      if( ! $this->user->isLoggedIn() && 
          $this->request->get('page') !== 'auth' && 
          ! $this->request->isAjax())
      {
        $this->response->redirect('?page=auth&action=login');
        return;
      }

      $route = $this->router->dispatch($this->request);
      $this->response->setContent($route);
      $this->response->send();
    } catch (\Throwable $e) 
    {
      $this->errorHandler->handle($e);
    }
  }

  public function getConfig(): Config
  {
    return $this->config;
  }

  public function getRouter(): Router
  {
    return $this->router;
  }

  public function getRequest(): Request
  {
    return $this->request;
  }

  public function getResponse(): Response
  {
    return $this->response;
  }

  public function getSession(): Session
  {
    return $this->session;
  }

  public function getUser(): User
  {
    return $this->user;
  }

  public function getErrorHandler(): ErrorHandler
  {
    return $this->errorHandler;
  }

  public function getCaptions(): Captions
  {
    return $this->captions;
  }
}
