<?php

namespace Modules\Programs\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Programs\Database\Factories\ProgramFactory;
use Modules\ProgramTypes\Models\ProgramType;

class Program extends Model
{
    use HasFactory, Uuid;
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'price',
        'image',
        'is_active',
        'program_type_id'
    ];

    public function program_type()
    {
        return $this->belongsTo(ProgramType::class);
    }
    
    protected static function newFactory()
    {
        return ProgramFactory::new();
    }
}
