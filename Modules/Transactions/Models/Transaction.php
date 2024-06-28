<?php

namespace Modules\Transactions\Models;

use App\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Programs\Models\Program;
use Modules\Transactions\Database\Factories\TransactionFactory;

class Transaction extends Model
{
    use HasFactory, Uuid;
   
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'exam_id',
        'code',
        'voucher_activated',
        'voucher_used',
        'total_purchases',
        'maximum_payment_time',
        'transaction_status',
        'voucher_token',
        'program_id ',
        'snap_token',
        'invoice',
        'program_id',
        'snap_token',
        'program_date',
        'program_time',
        'note',
        'discount'
    ];

    public static function generateCode()
    {
        $code = 'INV';
        $sequence = 1;
        $format = formatCode($code, $sequence);
        $result = null;

        while (true) {
            $query = static::where('code', $format)->first();
            if (empty($query)) {
                $result = $format;
                break;
            }
            $format = formatCode($code, ++$sequence);
        }
       
        return $result;
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getDateAttribute($value)
    {
        return dateFormat($value, 'd F Y');
    }

    public function getVoucherExpiredDateAttribute($value)
    {
        return empty($value) ? '-' : dateFormat($value, 'd F Y');
    }

    public function getMaximumPaymentTimeAttribute($value)
    {
        return dateFormat($value, 'd F Y H:i');
    }

    public function getCreatedAtAttribute($value)
    {
        return dateFormat($value, 'd F Y H:i');
    }

    public function getIsExpiredAttribute()
    {
        return $this->attributes['voucher_expired_date'] < Carbon::now() ? true : false; 
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    
    protected static function newFactory()
    {
        return TransactionFactory::new();
    }
}
