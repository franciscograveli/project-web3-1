<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAutorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => [
                'required',
                'string',
                'max:45',
                Rule::unique('autores', 'nome')->ignore($this->route('autor')),
            ],
            'nacionalidade' => ['nullable', 'string', 'max:45'],
            'nascimento' => ['required', 'date', 'before:today'],
            'biografia' => ['nullable', 'string'],
        ];
    }
}
