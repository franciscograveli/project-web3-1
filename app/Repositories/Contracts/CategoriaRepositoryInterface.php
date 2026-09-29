<?php

namespace App\Repositories\Contracts;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Collection;
use JasonGuru\LaravelMakeRepository\Repository\RepositoryContract;

interface CategoriaRepositoryInterface extends RepositoryContract
{
    public function list(): Collection;

    public function update(array $data, Categoria $categoria): Categoria;
}
