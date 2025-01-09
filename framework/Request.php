<?php

namespace SimpleFramework;

class Request
{
  private array $get;
  private array $post;
  private array $server;
  private array $files;
  private ?array $json;

  public function __construct()
  {
    $this->get = $_GET;
    $this->post = $_POST;
    $this->server = $_SERVER;
    $this->files = $_FILES;
    $this->json = null;

    if( $this->isJson())
    {
      $input = file_get_contents('php://input');
      $this->json = json_decode($input, true);
    }
  }

  public function get(string $key = null)
  {
    if( $key === null)
      return $this->get;

    return $this->get[$key] ?? null;
  }

  public function post(string $key = null)
  {
    if( $key === null)
      return $this->post;

    return $this->post[$key] ?? null;
  }

  public function isJson(): bool
  {
    return isset($this->server['CONTENT_TYPE']) && 
           strpos($this->server['CONTENT_TYPE'], 'application/json') !== false;
  }

  public function json(string $key = null)
  {
    if( $key === null)
      return $this->json;

    return $this->json[$key] ?? null;
  }

  public function isAjax(): bool
  {
    return isset($this->server['HTTP_X_REQUESTED_WITH']) && 
           strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
  }

  public function getMethod(): string
  {
    return $this->server['REQUEST_METHOD'];
  }

  public function getUri(): string
  {
    return $this->server['REQUEST_URI'];
  }
}
