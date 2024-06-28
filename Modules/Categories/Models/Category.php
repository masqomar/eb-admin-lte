<?php

namespace Modules\Categories\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Categories\Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory, Uuid;
   
    public $incrementing = false;

    protected $keyType = 'string';
    
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}
