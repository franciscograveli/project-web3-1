<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    /** @use HasFactory<\Database\Factories\LivroFactory> */
    protected $table = 'livros';

    protected $fillable = [
        'titulo',
        'isbn',
        'anopublicacao',
        'descricao',
        'paginas',
        'idAutor',
        'idCategoria',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $primaryKey = 'id';

    public $timestamps = true;

    public function autor()
    {
        return $this->belongsTo(Autor::class, 'idAutor');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria');
    }
    use HasFactory;
}
