<?php

namespace App\Services;

use App\Models\Categoria;
use App\Repositories\Contracts\CategoriaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoriaService
{
    public function __construct(private CategoriaRepositoryInterface $categoriaRepository) {}

    public function list(): Collection
    {
        return $this->categoriaRepository->list();
    }

    public function create(array $data): Categoria
    {
        /** @var Categoria */
        return $this->categoriaRepository->create($data);
    }

    public function update(array $data, Categoria $categoria): Categoria
    {
        return $this->categoriaRepository->update($data, $categoria);
    }

    public function delete(Categoria $categoria): bool
    {
        return (bool) $this->categoriaRepository->deleteById($categoria->id);
    }
}
