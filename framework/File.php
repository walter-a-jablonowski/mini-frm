<?php

namespace SimpleFramework;

use Symfony\Component\Yaml\Yaml;

class File extends Entity
{
  private string  $basePath;
  private string  $relativePath;
  private ?string $extension = null;

  public function __construct(string $relativePath)
  {
    parent::__construct();
    $rootDir = dirname(__DIR__);
    
    if( strpos($relativePath, 'config/') === 0)
      $this->basePath = $rootDir;
    else
      $this->basePath = $rootDir . '/data';
      
    $this->relativePath = $relativePath;
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
    if( !$this->extension)
      $this->extension = 'yaml';

    return sprintf('%s/%s.%s', 
      $this->basePath, 
      $this->relativePath,
      $this->extension
    );
  }

  public function save(): void
  {
    $path = $this->fullPath();
    $dir = dirname($path);

    if( !is_dir($dir))
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
    $extensions = ['yaml', 'yml', 'json'];

    foreach($extensions as $ext)
    {
      $path = sprintf('%s/%s.%s', 
        $this->basePath, 
        $this->relativePath,
        $ext
      );

      if( file_exists($path))
      {
        $this->extension = $ext;
        return;
      }
    }
  }
}
