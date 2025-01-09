<?php

namespace SimpleFramework;

use Symfony\Component\Yaml\Yaml;

class File extends Entity
{
  private string  $base;
  private string  $identifier;
  private string  $full;  // currently with base but no ext
  private ?string $extension = null;

  public function __construct( string $base, string $identifier)
  {
    parent::__construct();
          
    $this->base = $base;
    $this->identifier = $identifier;
    $this->full = "$base/$identifier";
    $this->findExtension();
  }

  public function load(): void
  {
    $path = $this->fullPath();
    
    if( ! file_exists($path))
    {
      $this->data = [];
      return;
    }
    
    $content = file_get_contents($path);
    
    switch($this->extension)
    {
      case 'yml':
      case 'yaml':
        $this->data = Yaml::parse($content) ?? [];
        break;
      case 'json':
        $this->data = json_decode($content, true) ?? [];
        break;
      default:
        $this->data = ['content' => $content];
    }
  }

  public function fullPath(): string
  {
    if( ! $this->extension)
      $this->findExtension();
      
    if( ! $this->extension)
      $this->extension = 'yml';

    return $this->full . '.' . $this->extension;
  }

  public function save(): void
  {
    $path = $this->fullPath();
    $dir = dirname($path);

    if( ! is_dir($dir))
      mkdir($dir, 0777, true);

    switch($this->extension)
    {
      case 'yml':
      case 'yaml':
        $content = Yaml::dump($this->data, 4);
        break;
      case 'json':
        $content = json_encode($this->data, JSON_PRETTY_PRINT);
        break;
      default:
        $content = $this->data['content'] ?? '';
    }

    file_put_contents($path, $content);
  }

  private function findExtension(): void
  {
    $extensions = ['yml', 'yaml', 'json'];
    
    // First check if the path already has an extension

    $pathInfo = pathinfo($this->full);

    if( isset($pathInfo['extension']) && in_array($pathInfo['extension'], $extensions))
    {
      $this->extension  = $pathInfo['extension'];
      $this->full = $pathInfo['dirname'] . '/' . $pathInfo['filename'];
      return;
    }

    // Then check for existing files
    foreach($extensions as $ext)
    {
      $path = $this->full . '.' . $this->extension;

      if( file_exists($path))
      {
        $this->extension = $ext;
        return;
      }
    }
  }
}
