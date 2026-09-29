<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Autor extends Model
{
    /** @use HasFactory<\Database\Factories\AutorFactory> */
    use HasFactory;

    protected $table = 'autores';

    protected $fillable = [
        'nome',
        'nacionalidade',
        'nascimento',
        'biografia',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'nascimento' => 'date',
        ];
    }

    public function livros(): HasMany
    {
        return $this->hasMany(Livro::class);
    }
}
