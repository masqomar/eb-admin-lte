<?php

namespace App\Http\Requests\V1\Coupons;

use Illuminate\Foundation\Http\FormRequest;;

class CreateCouponRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }
}
