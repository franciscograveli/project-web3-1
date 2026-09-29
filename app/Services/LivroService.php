<?php

namespace App\Services;

use App\Models\Livro;
use App\Repositories\Contracts\LivroRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class LivroService
{
    public function __construct(private LivroRepositoryInterface $livroRepository) {}

    public function list(): Collection
    {
        return $this->livroRepository->list();
    }

    public function show(Livro $livro): Livro
    {
        return $livro->load(['autor', 'categoria']);
    }

    public function create(array $data): Livro
    {
        /** @var Livro */
        $livro = $this->livroRepository->create($data);

        return $livro->load(['autor', 'categoria']);
    }

    public function update(array $data, Livro $livro): Livro
    {
        return $this->livroRepository->update($data, $livro)->load(['autor', 'categoria']);
    }

    public function delete(Livro $livro): bool
    {
        return (bool) $this->livroRepository->deleteById($livro->id);
    }
}
