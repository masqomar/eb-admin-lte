<?php

namespace App\Http\Requests\V1\Programs;

use Illuminate\Foundation\Http\FormRequest;;

class CreateProgramRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }
}
