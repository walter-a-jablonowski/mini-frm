<?php

namespace SimpleFramework;

class Captions
{
  private File $file;

  public function __construct()
  {
    $this->file = new File('config/captions');
    
    if( !file_exists($this->file->fullPath()))
    {
      $dir = dirname($this->file->fullPath());
      if( !is_dir($dir))
        mkdir($dir, 0777, true);
      
      $this->setDefaults();
      $this->file->save();
    }

    $this->file->load();
  }

  private function setDefaults(): void
  {
    $this->file->data = [
      'login' => [
        'title' => 'Login',
        'username' => 'Username',
        'password' => 'Password',
        'submit' => 'Login',
        'register_link' => 'Register new account',
        'error' => 'Invalid username or password'
      ],
      'register' => [
        'title' => 'Register',
        'username' => 'Username',
        'password' => 'Password',
        'submit' => 'Register',
        'login_link' => 'Back to login',
        'error' => 'Username already exists'
      ],
      'index' => [
        'title' => 'Welcome',
        'logout' => 'Logout'
      ]
    ];
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
