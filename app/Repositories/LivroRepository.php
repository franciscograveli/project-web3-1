<?php

namespace App\Repositories;

use App\Models\Livro;
use App\Repositories\Contracts\LivroRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class LivroRepository extends BaseRepository implements LivroRepositoryInterface
{
    /**
     * Return the fully-qualified model class name.
     */
    public function model(): string
    {
        return Livro::class;
    }

    public function list(int $perPage): LengthAwarePaginator
    {
        return $this->with(['autor', 'categoria'])->orderBy('titulo')->paginate($perPage);
    }

    public function update(array $data, Livro $livro): Livro
    {
        /** @var Livro */
        return $this->updateById($livro->id, $data);
    }
}
