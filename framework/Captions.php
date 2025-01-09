<?php

namespace SimpleFramework;

class Captions extends Entity
{
  private File $file;

  public function __construct()
  {
    parent::__construct();
    $this->file = new File('config/captions');
    
    if( ! file_exists($this->file->fullPath()))
    {
      $dir = dirname($this->file->fullPath());
      if( !is_dir($dir))
        mkdir($dir, 0777, true);
      
      $this->setDefaults();
      $this->save();
    }

    $this->load();
  }

  private function setDefaults(): void
  {
    $this->data = [
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

  public function load(): void
  {
    $this->file->load();
    $this->data = $this->file->data['captions'] ?? $this->data;
  }

  public function save(): void
  {
    $this->file->data = ['captions' => $this->data];
    $this->file->save();
  }
}
