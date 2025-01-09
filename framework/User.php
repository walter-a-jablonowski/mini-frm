<?php

namespace SimpleFramework;

use Symfony\Component\Yaml\Yaml;

class User
{
  private ?File $file = null;
  private ?self $currentUser = null;

  public function __construct( string $key, $value )  
  {
    if( $key === 'id')
    {
      // When loading by ID, we need to find the username first
      foreach( self::getAllUsers() as $user)
      {
        if( (int)$user->get('id') === (int)$value)
        {
          $this->file = $user->file;
          $this->file->load();
          return;
        }
      }

      throw new \RuntimeException("User not found");
    }
    
    // Loading by username (or other keys)
    $this->file = new File("data/users/$value/-this");
      
    if( ! file_exists($this->file->fullPath()))
      throw new \RuntimeException("User not found");
      
    $this->file->load();
    
    if( $this->get('id') === null || 
        $this->get('username') === null || 
        $this->get('password') === null ||
        ($key === 'username' && $this->get('username') !== $value))
    {
      throw new \RuntimeException("Invalid user data");
    }
  }

  public static function getAllUsers(): array
  {
    $users = [];

    foreach( scandir('data/users') as $username)
    {
      if( ! is_dir("data/users/$username") || in_array($username, ['.', '..']))
        continue;

      $users[] = new self('username', $username);
    }

    return $users;
  }

  public function register( string $username, string $password ): bool
  {
    if( self::findBy('username', $username))
      return false;
      
    $users = self::getAllUsers();
    $id = count($users) + 1;
    
    $userFile = new File("data/users/{$username}/-this");
    $userFile->set('id', $id);
    $userFile->set('username', $username);
    $userFile->set('password', password_hash($password, PASSWORD_DEFAULT));
    $userFile->save();
    
    return true;
  }

  public static function findBy(string $key, $value): ?self
  {
    try 
    {
      return new self($key, $value);
    }
    catch(\RuntimeException $e)
    {
      return null;
    }
  }

  public function isLoggedIn(): bool  // makes sense here ($someUser->isLoggedIn()) and in app
  {
    $app = App::getInstance();
    $userId = $app->getSession()->get('user_id');
    return $userId !== null && (int)$userId === (int)$this->get('id');
  }

  public function login(string $username, string $password): bool
  {
    if( $username !== $this->get('username'))
    {
      return false;
    }
    
    if( ! password_verify($password, $this->get('password')))
    {
      return false;
    }
      
    $app = App::getInstance();
    $app->getSession()->set('user_id', (int)$this->get('id'));
    $this->currentUser = $this;
    $app->setCurrentUser($this);
    
    return true;
  }

  public function get(string $key, $default = null)
  {
    return $this->file?->get($key, $default);
  }

  public function set(string $key, $value): void
  {
    if( ! $this->file)
      return;
      
    $this->file->set($key, $value);
    $this->file->save();
  }

  public function logout(): void
  {
    $app = App::getInstance();
    $app->getSession()->remove('user_id');
    $app->setCurrentUser(null);
    
    $this->currentUser = null;
    $this->file = null;
  }
}
