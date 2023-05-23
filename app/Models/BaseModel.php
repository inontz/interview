<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use Cachable;

    protected $cachePrefix = 'interview-store';

    protected $cacheCooldownSeconds = 300; // 5 minutes
}
