<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutorResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'nacionalidade' => $this->nacionalidade,
            'nascimento' => $this->nascimento?->format('Y-m-d'),
            'biografia' => $this->biografia,
            'livros' => LivroResource::collection($this->whenLoaded('livros')),
        ];
    }
}
