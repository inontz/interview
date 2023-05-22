<?php
namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BaseModel extends Model
{
    use Cachable;

    protected $cachePrefix = "test-prefix";
    protected $cacheCooldownSeconds = 300; // 5 minutes
}
