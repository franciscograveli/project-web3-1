<?php

namespace App\Repositories;

use App\Models\Autor;
use App\Repositories\Contracts\AutorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
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

    public function list(): Collection
    {
        return $this->orderBy('nome')->get();
    }

    public function update(array $data, Autor $autor): Autor
    {
        /** @var Autor */
        return $this->updateById($autor->id, $data);
    }
}
