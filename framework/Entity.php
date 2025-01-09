<?php

namespace SimpleFramework;

abstract class Entity
{
  protected array $data = [];

  public function __construct()
  {
    $this->data = [];
  }

  abstract public function load(): void;

  public function __get(string $name)
  {
    return $this->data[$name] ?? null;
  }

  public function get(string $key, mixed $default = null): mixed
  {
    $parts = explode('.', $key);
    $data = $this->data;
    
    foreach($parts as $part)
    {
      if( !isset($data[$part]))
        return $default;
        
      $data = $data[$part];
    }
    
    return $data;
  }

  public function __set(string $name, $value): void
  {
    $this->data[$name] = $value;
  }

  public function set(string $key, mixed $value): void
  {
    $parts = explode('.', $key);
    $lastKey = array_pop($parts);
    $data = &$this->data;
    
    foreach($parts as $part)
    {
      if( !isset($data[$part]))
        $data[$part] = [];
      
      $data = &$data[$part];
    }
    
    $data[$lastKey] = $value;
  }
}
