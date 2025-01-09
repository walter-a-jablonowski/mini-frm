<?php

namespace SimpleFramework;

class Cache
{
  private File $file;

  public function __construct(string $namespace)
  {
    $this->file = new File("data/{$namespace}");
    
    if( ! file_exists($this->file->fullPath()))
    {
      $dir = dirname($this->file->fullPath());
      if( !is_dir($dir))
        mkdir($dir, 0777, true);
      
      $this->file->save();
    }
    
    $this->file->load();
  }

  public function get(string $key)
  {
    $data = $this->file->get($key);
    
    if( $data === null)
      return null;

    if( time() > $data['expires'])
    {
      $this->remove($key);
      return null;
    }

    return $data['value'];
  }

  public function set(string $key, $value, int $ttl = 3600): void
  {
    $this->file->set($key, [
      'value' => $value,
      'expires' => time() + $ttl
    ]);
    
    $this->file->save();
  }

  public function remove(string $key): void
  {
    $this->file->remove($key);
    $this->file->save();
  }

  public function clear(): void
  {
    $this->file = new File("data/{$this->namespace}");
    $this->file->save();
  }
}
