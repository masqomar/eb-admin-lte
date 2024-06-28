<?php

namespace Modules\Coupons\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coupons\Database\Factories\CouponFactory;
use Modules\Programs\Models\Program;

class Coupon extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'string';

    function program()
    {
        return $this->belongsTo(Program::class);
    }

    protected static function newFactory()
    {
        return CouponFactory::new();
    }
}
