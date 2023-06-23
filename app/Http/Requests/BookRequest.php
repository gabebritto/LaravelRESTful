<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('books')->ignore($this->id)],
            'publication_date' => ['required', 'date'],
            'available_qty' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
