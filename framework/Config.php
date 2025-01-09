<?php

namespace SimpleFramework;

class Config extends Entity
{
  private File $file;

  public function __construct()
  {
    parent::__construct();
    $this->file = new File('config/config');
    $this->load();
  }

  public function load(): void 
  {
    $this->file->load();
    $this->data = $this->file->data;

    if( empty($this->data))
    {
      // Set default configuration
      $this->data = [
        'debug' => true,
        'timezone' => 'Europe/Berlin',
        'database' => [
          'host' => 'localhost',
          'name' => 'simple_framework',
          'user' => 'root',
          'pass' => ''
        ]
      ];
      $this->save();
    }
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

  public function save(): void
  {
    $this->file->data = $this->data;
    $this->file->save();
  }
}
