<?php

namespace App\Repositories;

use App\Models\Categoria;
use App\Repositories\Contracts\CategoriaRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function list(int $perPage): LengthAwarePaginator
    {
        return $this->orderBy('nome')->paginate($perPage);
    }

    public function update(array $data, Categoria $categoria): Categoria
    {
        /** @var Categoria */
        return $this->updateById($categoria->id, $data);
    }
}
