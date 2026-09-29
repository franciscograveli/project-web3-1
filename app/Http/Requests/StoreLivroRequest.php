<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLivroRequest extends FormRequest
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
            'titulo' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:45', 'unique:livros,isbn'],
            'ano_publicacao' => ['required', 'integer', 'min:0', 'max:'.now()->year],
            'descricao' => ['required', 'string', 'max:255'],
            'paginas' => ['required', 'integer', 'min:1'],
            'autor_id' => ['required', 'integer', 'exists:autores,id'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
        ];
    }
}
