<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    /** @use HasFactory<\Database\Factories\AutorFactory> */

    protected $table = 'autores';

    protected $fillable = [
        'nome',
        'nacionalidade',
        'nascimento',
        'biografia',
    ];

    protected $dates = [
        'nascimento',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = true;

    public function livros()
    {
        return $this->hasMany(Livro::class, 'idAutor');
    }
    use HasFactory;
}
