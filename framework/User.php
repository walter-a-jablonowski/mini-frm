<?php

namespace SimpleFramework;

class User extends Entity
{
  private File $file;
  private ?array $currentUser = null;
  private Session $session;

  public function __construct(Session $session)
  {
    parent::__construct();
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
    $this->data = $this->file->data['users'] ?? [];
    
    if( $this->session->has('user_id'))
      $this->currentUser = $this->findById($this->session->get('user_id'));
  }

  public function register(string $username, string $password): bool
  {
    if( $this->findByUsername($username))
      return false;
      
    $id = count($this->data) + 1;
    $this->data[] = [
      'id' => $id,
      'username' => $username,
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ];
    
    $this->save();
    return true;
  }

  private function findById(int $id): ?array
  {
    foreach($this->data as $user)
      if( $user['id'] === $id)
        return $user;
    return null;
  }

  private function findByUsername(string $username): ?array
  {
    foreach($this->data as $user)
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

  public function load(): void
  {
    $this->file->load();
    $this->data = $this->file->data['users'] ?? [];
  }

  public function save(): void
  {
    $this->file->data = ['users' => $this->data];
    $this->file->save();
  }

  public function logout(): void
  {
    $this->session->remove('user_id');
    $this->currentUser = null;
  }
}
