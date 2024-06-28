<?php

namespace App\Http\Requests\V1\ProgramTypes;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }
}
