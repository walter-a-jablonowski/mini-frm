<?php

namespace SimpleFramework;

class User
{
  private File $file;
  private ?array $currentUser = null;
  private Session $session;

  public function __construct(Session $session)
  {
    $this->session = $session;
    $this->file = new File('users/users');
    
    if( !file_exists($this->file->fullPath()))
    {
      $dir = dirname($this->file->fullPath());
      if( !is_dir($dir))
        mkdir($dir, 0777, true);
      
      $this->file->data = ['users' => []];
      $this->file->save();
      error_log("Created new users file");
    }

    $this->file->load();
    error_log("Loaded users file. Current users: " . print_r($this->file->data, true));
    
    if( $this->session->has('user_id'))
    {
      $this->currentUser = $this->findById($this->session->get('user_id'));
      error_log("Current user from session: " . print_r($this->currentUser, true));
    }
  }

  public function register(string $username, string $password): bool
  {
    error_log("Register attempt for username: " . $username);
    
    if( $this->findByUsername($username))
    {
      error_log("Registration failed - Username already exists: " . $username);
      return false;
    }
      
    $users = $this->file->data['users'] ?? [];
    $id = count($users) + 1;
    $users[] = [
      'id' => $id,
      'username' => $username,
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ];
    
    $this->file->data = ['users' => $users];
    $this->file->save();
    error_log("User registered successfully: " . $username);
    return true;
  }

  private function findById(int $id): ?array
  {
    error_log("Finding user by ID: " . $id);
    $users = $this->file->data['users'] ?? [];
    foreach($users as $user)
      if( $user['id'] === $id)
      {
        error_log("Found user by ID: " . print_r($user, true));
        return $user;
      }
    error_log("User not found by ID: " . $id);
    return null;
  }

  private function findByUsername(string $username): ?array
  {
    error_log("Finding user by username: " . $username);
    $users = $this->file->data['users'] ?? [];
    foreach($users as $user)
      if( $user['username'] === $username)
      {
        error_log("Found user by username: " . print_r($user, true));
        return $user;
      }
    error_log("User not found by username: " . $username);
    return null;
  }

  public function getCurrentUser(): ?array
  {
    return $this->currentUser;
  }

  public function isLoggedIn(): bool
  {
    return $this->currentUser !== null;
  }

  public function login(string $username, string $password): bool
  {
    error_log("Login attempt for username: " . $username);
    
    $user = $this->findByUsername($username);
    if( !$user)
    {
      error_log("Login failed - User not found: " . $username);
      return false;
    }
    
    if( !password_verify($password, $user['password']))
    {
      error_log("Login failed - Invalid password for user: " . $username);
      return false;
    }
      
    $this->session->set('user_id', $user['id']);
    $this->currentUser = $user;
    error_log("Login successful for user: " . print_r($user, true));
    return true;
  }

  public function get(string $key, mixed $default = null): mixed
  {
    return $this->file->get($key, $default);
  }

  public function set(string $key, mixed $value): void
  {
    $this->file->set($key, $value);
  }

  public function logout(): void
  {
    error_log("Logging out user: " . print_r($this->currentUser, true));
    $this->session->remove('user_id');
    $this->currentUser = null;
  }
}
