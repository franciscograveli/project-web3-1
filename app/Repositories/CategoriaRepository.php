<?php

namespace App\Repositories;

use App\Models\Categoria;
use App\Repositories\Contracts\CategoriaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class CategoriaRepository extends BaseRepository implements CategoriaRepositoryInterface
{
    /**
     * Return the fully-qualified model class name.
     */
    public function model(): string
    {
        return Categoria::class;
    }

    public function list(): Collection
    {
        return $this->orderBy('nome')->get();
    }

    public function update(array $data, Categoria $categoria): Categoria
    {
        /** @var Categoria */
        return $this->updateById($categoria->id, $data);
    }
}
