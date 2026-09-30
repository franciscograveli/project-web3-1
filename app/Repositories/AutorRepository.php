<?php

namespace App\Repositories;

use App\Models\Autor;
use App\Repositories\Contracts\AutorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class AutorRepository extends BaseRepository implements AutorRepositoryInterface
{
    /**
     * Return the fully-qualified model class name.
     */
    public function model(): string
    {
        return Autor::class;
    }

    public function list(int $perPage): LengthAwarePaginator
    {
        return $this->orderBy('nome')->paginate($perPage);
    }

    public function update(array $data, Autor $autor): Autor
    {
        /** @var Autor */
        return $this->updateById($autor->id, $data);
    }
}
