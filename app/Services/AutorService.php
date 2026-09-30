<?php

namespace App\Services;

use App\Exceptions\RegistroVinculadoException;
use App\Models\Autor;
use App\Repositories\Contracts\AutorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AutorService
{
    public function __construct(private AutorRepositoryInterface $autorRepository) {}

    public function list(int $perPage): LengthAwarePaginator
    {
        return $this->autorRepository->list($perPage);
    }

    public function show(Autor $autor): Autor
    {
        return $autor->load('livros');
    }

    public function create(array $data): Autor
    {
        /** @var Autor */
        return $this->autorRepository->create($data);
    }

    public function update(array $data, Autor $autor): Autor
    {
        return $this->autorRepository->update($data, $autor);
    }

    public function delete(Autor $autor): bool
    {
        if ($autor->livros()->exists()) {
            throw new RegistroVinculadoException('Não é possível excluir um autor com livros vinculados');
        }

        return (bool) $this->autorRepository->deleteById($autor->id);
    }
}
