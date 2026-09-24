<?php

namespace App\Services;

use App\Repositories\Contracts\CategoriaRepositoryInterface;
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
}
