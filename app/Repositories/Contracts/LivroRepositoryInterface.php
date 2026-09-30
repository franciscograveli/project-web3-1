<?php

namespace App\Repositories\Contracts;

use App\Models\Livro;
use Illuminate\Pagination\LengthAwarePaginator;
use JasonGuru\LaravelMakeRepository\Repository\RepositoryContract;

interface LivroRepositoryInterface extends RepositoryContract
{
    public function list(int $perPage): LengthAwarePaginator;

    public function update(array $data, Livro $livro): Livro;
}
