<?php

namespace App\Http\Library;

use Illuminate\Support\Facades\Cache;

class Cacher
{
    public function __construct(public string $store = 'redis')
    {
    }
   //file //redis

    public function setCached($key, $value)
    {

        $cachedData = Cache::store($this->store)->put($key, $value);

    }

  public function getCached($key)
  {

      $cachedData = Cache::store($this->store)->get($key);
      if ($cachedData) {
          return json_decode($cachedData);
      }

  }

    public function removeCached($key)
    {

        Cache::store($this->store)->forget($key);

    }
}
