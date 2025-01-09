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

  public function __set(string $name, $value): void
  {
    $this->data[$name] = $value;
  }
}
