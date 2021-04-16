<?php

class Cache {
  const CACHE_LIFE = 1; // minutes
  const CACHE_DIR = 'cache' ;

  private function CacheFileName($key) {
    if (!file_exists(self::CACHE_DIR)) {
      mkdir(self::CACHE_DIR, 0777, true);
    }

    return self::CACHE_DIR . DIRECTORY_SEPARATOR . md5($key);
  }

  public function getCache($key, $cache_life = self::CACHE_LIFE) {
    $cache_life = intval($cache_life);
    if ($cache_life <= 0) return null;

    $filePath = $this->CacheFileName($key);

    if (file_exists($filePath)) {
      if (filemtime($filePath) > (time() - 60 * $cache_life)) {
        return file_get_contents($filePath);
      } else {
        unlink($filePath);
      }
    }

    return null;
  }

  public function setCache($key, $json, $cache_lifetime = self::CACHE_LIFE) {
    if(intval($cache_lifetime) > 0) {
      $filePath = $this->CacheFileName($key);
      file_put_contents($filePath, $json, LOCK_EX);
    }

    return $json;
  }

}