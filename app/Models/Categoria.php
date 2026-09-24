<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriaFactory> */
    protected $table = 'categorias';

    protected $fillable = ['nome', 'descricao'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $primaryKey = 'id';

    public $timestamps = true;

    use HasFactory;
}
