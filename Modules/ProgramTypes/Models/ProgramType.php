<?php

namespace Modules\ProgramTypes\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Categories\Models\Category;
use Modules\Programs\Models\Program;
use Modules\ProgramTypes\Database\Factories\ProgramTypeFactory;

class ProgramType extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'category_id',
    ];
    
    public function program()
    {
        return $this->hasMany(Program::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function newFactory()
    {
        return ProgramTypeFactory::new();
    }
}
