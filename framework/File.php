<?php

namespace SimpleFramework;

class File extends Entity
{
  private string $basePath;
  private string $relativePath;
  private ?string $extension = null;

  public function __construct(string $relativePath)
  {
    parent::__construct();
    $this->basePath = dirname(__DIR__) . '/data';
    $this->relativePath = $relativePath;
    $this->findExtension();
  }

  public function load(): void
  {
    $path = $this->fullPath();
    
    if( !file_exists($path))
    {
      $this->data = [];
      return;
    }
    
    $content = file_get_contents($path);
    
    switch($this->extension)
    {
      case 'json':
        $this->data = json_decode($content, true) ?? [];
        break;
      case 'yml':
      case 'yaml':
        $this->data = \Symfony\Component\Yaml\Yaml::parse($content) ?? [];
        break;
      default:
        $this->data = ['content' => $content];
    }
  }

  public function fullPath(): string
  {
    if( !$this->extension)
      $this->extension = 'json';

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
      
    $content = '';

    switch($this->extension)
    {
      case 'json':
        $content = json_encode($this->data, JSON_PRETTY_PRINT);
        break;
      case 'yml':
      case 'yaml':
        $content = \Symfony\Component\Yaml\Yaml::dump($this->data);
        break;
      default:
        $content = $this->data['content'] ?? '';
    }
    
    file_put_contents($path, $content);
  }

  private function findExtension(): void
  {
    $extensions = ['json', 'yml', 'yaml'];
    
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