<?php

namespace SimpleFramework;

class Response
{
  private int $statusCode = 200;
  private array $headers = [];
  private string $content = '';

  public function setStatusCode(int $code): self
  {
    $this->statusCode = $code;
    return $this;
  }

  public function setHeader(string $name, string $value): self
  {
    $this->headers[$name] = $value;
    return $this;
  }

  public function setContent(string $content): self
  {
    $this->content = $content;
    return $this;
  }

  public function redirect(string $url): void
  {
    header('Location: ' . $url);
    exit;
  }

  public function json(array $data): self
  {
    $this->setHeader('Content-Type', 'application/json');
    $this->content = json_encode($data);
    return $this;
  }

  public function send(): void
  {
    http_response_code($this->statusCode);

    foreach($this->headers as $name => $value)
      header("$name: $value");

    echo $this->content;
    exit;
  }
}
