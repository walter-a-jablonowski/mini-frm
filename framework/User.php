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
    }

    $this->file->load();
    
    if( $this->session->has('user_id'))
      $this->currentUser = $this->findById($this->session->get('user_id'));
  }

  public function register(string $username, string $password): bool
  {
    if( $this->findByUsername($username))
      return false;
      
    $users = $this->file->data['users'] ?? [];
    $id = count($users) + 1;
    $users[] = [
      'id' => $id,
      'username' => $username,
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ];
    
    $this->file->data = ['users' => $users];
    $this->file->save();
    return true;
  }

  private function findById(int $id): ?array
  {
    $users = $this->file->data['users'] ?? [];
    foreach($users as $user)
      if( $user['id'] === $id)
        return $user;
    return null;
  }

  private function findByUsername(string $username): ?array
  {
    $users = $this->file->data['users'] ?? [];
    foreach($users as $user)
      if( $user['username'] === $username)
        return $user;
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
    $user = $this->findByUsername($username);
    if( ! $user || ! password_verify($password, $user['password']))
      return false;
      
    $this->session->set('user_id', $user['id']);
    $this->currentUser = $user;
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
    $this->session->remove('user_id');
    $this->currentUser = null;
  }
}
