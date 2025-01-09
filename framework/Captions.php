<?php

namespace SimpleFramework;

class Captions
{
  private File $file;

  public function __construct()
  {
    $this->file = new File('config', 'captions');
    $this->file->load();
  }

  public function get(string $key, $default = null)
  {
    return $this->file->get($key, $default);
  }

  public function set(string $key, $value): void
  {
    $this->file->set($key, $value);
  }
}
