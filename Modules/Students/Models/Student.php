<?php

namespace Modules\Students\Models;

use App\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Students\Database\Factories\StudentFactory;

class Student extends Model
{
    use HasFactory, Uuid;
   
    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'member_access' => 'json',
    ];

    protected $fillable = [
        'id',
        'user_id',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'address',
        'phone_number',
        'gender',
        'is_member', // true, false
        'member_access',
    ];

    protected $dates = [
        'member_expiration_date'
    ];

    public function getPhoneNumberAttribute($value)
    {
        $value = str_replace(" ","",$value);
        $value = str_replace("(","",$value);
        $value = str_replace(")","",$value);
        $value = str_replace(".","",$value);

        if(!preg_match('/[^+0-9]/',trim($value))){
            if(substr(trim($value), 0, 3)=='+62'){
                $result = trim($value);
            }

            elseif(substr(trim($value), 0, 1)=='0'){
                $result = '+62'.substr(trim($value), 1);
            } else {
                $result = $value;
            }
        }

        return str_replace("+" ,"", $result);
    }

    public function getMemberExpirationDateAttribute($value)
    {
        return empty($value) ? '-' : Carbon::parse($value)->format('d F Y');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // public function province()
    // {
    //     return $this->belongsTo(\App\Models\Region\Province::class);
    // }

    // public function city()
    // {
    //     return $this->belongsTo(\App\Models\Region\City::class);
    // }

    // public function district()
    // {
    //     return $this->belongsTo(\App\Models\Region\District::class);
    // }

    // public function village()
    // {
    //     return $this->belongsTo(\App\Models\Region\Village::class);
    // }
    
    protected static function newFactory()
    {
        return StudentFactory::new();
    }
}
