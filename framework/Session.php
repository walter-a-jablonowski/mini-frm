<?php

namespace SimpleFramework;

class Session
{
  private Cache $cache;

  public function __construct()
  {
    if( session_status() === PHP_SESSION_NONE)
      session_start();

    $this->cache = new Cache('session_cache/' . session_id() . '-this');
  }

  public function set(string $key, $value) : void
  {
    $_SESSION[$key] = $value;
  }

  public function get(string $key)
  {
    return $_SESSION[$key] ?? null;
  }

  public function remove(string $key) : void
  {
    unset($_SESSION[$key]);
  }

  public function destroy() : void
  {
    session_destroy();
  }

  public function getCache() : Cache
  {
    return $this->cache;
  }

  public function has(string $key) : bool
  {
    return isset($_SESSION[$key]);
  }
}
