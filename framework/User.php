<?php

namespace SimpleFramework;

use Symfony\Component\Yaml\Yaml;

class User
{
  private ?File   $file = null;
  private ?self   $currentUser = null;

  public function __construct( string $key, $value )  
  {
    error_log("User->__construct: Loading user with $key = $value");
    
    if( $key === 'id')
    {
      // When loading by ID, we need to find the username first
      error_log("User->__construct: Looking for user by ID");
      foreach( self::getAllUsers() as $user)
      {
        if( (int)$user->get('id') === (int)$value)
        {
          error_log("User->__construct: Found user by ID, username: " . $user->get('username'));
          $this->file = $user->file;
          $this->file->load();
          return;
        }
      }
      error_log("User->__construct: User with ID $value not found");
      throw new \RuntimeException("User not found");
    }
    
    // Loading by username (or other keys)
    error_log("User->__construct: Loading user by $key");
    $this->file = new File("users/$value/-this");
      
    if( ! file_exists($this->file->fullPath()))
    {
      error_log("User->__construct: User file not found at: " . $this->file->fullPath());
      throw new \RuntimeException("User not found");
    }
      
    $this->file->load();
    
    if( $this->get('id') === null || 
        $this->get('username') === null || 
        $this->get('password') === null ||
        ($key === 'username' && $this->get('username') !== $value))
    {
      error_log("User->__construct: Invalid user data for $key = $value");
      throw new \RuntimeException("Invalid user data");
    }
    
    error_log("User->__construct: Successfully loaded user with $key = $value");
  }

  public static function getAllUsers(): array
  {
    $users = [];
    $dir   = new File('users');
    $path  = sprintf('%s/%s', $dir->getBasePath(), 'users');
    
    error_log("User->getAllUsers: Scanning directory: $path");
    
    if (!is_dir($path))
    {
      error_log("User->getAllUsers: Directory not found: $path");
      return [];
    }
    
    foreach(scandir($path) as $username)
    {
      if( $username === '.' || $username === '..')
        continue;
        
      try 
      {
        error_log("User->getAllUsers: Attempting to load user: $username");
        $users[] = new self('username', $username);
        error_log("User->getAllUsers: Successfully loaded user: $username");
      }
      catch(\RuntimeException $e) 
      {
        error_log("User->getAllUsers: Failed to load user $username: " . $e->getMessage());
        continue;
      }
    }

    return $users;
  }

  public function register( string $username, string $password ): bool
  {
    if( self::findBy('username', $username))
      return false;
      
    $users = self::getAllUsers();
    $id = count($users) + 1;
    
    $userFile = new File('users/' . $username . '/-this');
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
    error_log("User->isLoggedIn: Checking login state, session user_id: " . ($userId ?? 'null') . ", this user id: " . $this->get('id'));
    return $userId !== null && (int)$userId === (int)$this->get('id');
  }

  public function login(string $username, string $password): bool
  {
    error_log("User->login: Attempting login for username: $username");
    
    if( $username !== $this->get('username'))
    {
      error_log("User->login: Username mismatch");
      return false;
    }
    
    if( ! password_verify($password, $this->get('password')))
    {
      error_log("User->login: Invalid password");
      return false;
    }
      
    $app = App::getInstance();
    $app->getSession()->set('user_id', (int)$this->get('id'));
    $this->currentUser = $this;
    $app->setCurrentUser($this);
    
    error_log("User->login: Login successful, set user_id in session: " . $this->get('id'));
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
