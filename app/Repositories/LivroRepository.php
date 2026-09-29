<?php

namespace App\Repositories;

use App\Models\Livro;
use App\Repositories\Contracts\LivroRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
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

    public function list(): Collection
    {
        return $this->with(['autor', 'categoria'])->orderBy('titulo')->get();
    }

    public function update(array $data, Livro $livro): Livro
    {
        /** @var Livro */
        return $this->updateById($livro->id, $data);
    }
}
