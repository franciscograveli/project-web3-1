<?php

namespace App\Repositories\Contracts;

use App\Models\Categoria;
use JasonGuru\LaravelMakeRepository\Repository\RepositoryContract;

interface CategoriaRepositoryInterface extends RepositoryContract
{
    public function list();
    public function find(int $id);
    public function update(array $data, Categoria $categoria);
}
