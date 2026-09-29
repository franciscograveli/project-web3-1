<?php

namespace App\Repositories\Contracts;

use App\Models\Livro;
use Illuminate\Database\Eloquent\Collection;
use JasonGuru\LaravelMakeRepository\Repository\RepositoryContract;

interface LivroRepositoryInterface extends RepositoryContract
{
    public function list(): Collection;

    public function update(array $data, Livro $livro): Livro;
}
