<?php

namespace App\Repositories\Contracts;

use App\Models\Autor;
use Illuminate\Pagination\LengthAwarePaginator;
use JasonGuru\LaravelMakeRepository\Repository\RepositoryContract;

interface AutorRepositoryInterface extends RepositoryContract
{
    public function list(int $perPage): LengthAwarePaginator;

    public function update(array $data, Autor $autor): Autor;
}
