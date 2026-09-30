<?php

namespace App\Repositories\Contracts;

use App\Models\Categoria;
use Illuminate\Pagination\LengthAwarePaginator;
use JasonGuru\LaravelMakeRepository\Repository\RepositoryContract;

interface CategoriaRepositoryInterface extends RepositoryContract
{
    public function list(int $perPage): LengthAwarePaginator;

    public function update(array $data, Categoria $categoria): Categoria;
}
