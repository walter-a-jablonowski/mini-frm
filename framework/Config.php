<?php

namespace SimpleFramework;

class Config
{
  private File $file;

  public function __construct()
  {
    $this->file = new File('config/config');
    $this->load();
  }

  public function load(): void 
  {
    $this->file->load();

    if( empty($this->file->data))
    {
      // Set default configuration
      $this->file->data = [
        'debug' => true,
        'timezone' => 'Europe/Berlin',
        'database' => [
          'host' => 'localhost',
          'name' => 'simple_framework',
          'user' => 'root',
          'pass' => ''
        ]
      ];

      $this->file->save();
    }
  }

  public function get(string $key, mixed $default = null): mixed
  {
    return $this->file->get($key, $default);
  }

  public function set(string $key, mixed $value): void
  {
    $this->file->set($key, $value);
  }
}
