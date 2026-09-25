<?php

namespace App\Services;

use App\Repositories\Contracts\CategoriaRepositoryInterface;
use App\Models\Categoria;

/**
 * Class CategoriaService.
 */
class CategoriaService
{

    public function __construct(private CategoriaRepositoryInterface $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }
    public function list()
    {
        return $this->categoriaRepository->list();
    }

    public function create(array $data)
    {
        return $this->categoriaRepository->create($data);
    }

    public function find(int $id)
    {
        return $this->categoriaRepository->find($id);
    }

    public function update(array $data, Categoria $categoria) : Categoria
    {
        return $this->categoriaRepository->update($data, $categoria);
    }

    public function delete(Categoria $categoria): mixed
    {
        return $this->categoriaRepository->where('id', $categoria->id)->delete();
    }
}
