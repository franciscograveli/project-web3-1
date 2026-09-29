<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LivroResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'isbn' => $this->isbn,
            'ano_publicacao' => $this->ano_publicacao,
            'descricao' => $this->descricao,
            'paginas' => $this->paginas,
            'autor_id' => $this->autor_id,
            'categoria_id' => $this->categoria_id,
            'autor' => new AutorResource($this->whenLoaded('autor')),
            'categoria' => new CategoriaResource($this->whenLoaded('categoria')),
        ];
    }
}
