<?php

namespace App\Services;

use App\Exceptions\RegistroVinculadoException;
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

    public function show(Categoria $categoria): Categoria
    {
        return $categoria->load('livros');
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
        if ($categoria->livros()->exists()) {
            throw new RegistroVinculadoException('Não é possível excluir uma categoria com livros vinculados');
        }

        return (bool) $this->categoriaRepository->deleteById($categoria->id);
    }
}
