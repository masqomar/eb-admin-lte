<?php

namespace App\Http\Requests\V1\Transactions;

use Illuminate\Foundation\Http\FormRequest;;

class CreateTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }
}
