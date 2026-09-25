<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Repositories\Contracts\CategoriaRepositoryInterface;
use App\Models\Categoria;

class CategoriaRepository extends BaseRepository implements CategoriaRepositoryInterface
{
    /**
     * Return the fully-qualified model class name.
     */
    public function model(): string
    {
        return Categoria::class;
    }

    public function list()
    {
        return Categoria::all();
    }

    public function find(int $id)
    {
        return Categoria::find($id);
    }

    public function update(array $data, Categoria $categoria)
    {
        return $categoria->update($data);
    }

}
