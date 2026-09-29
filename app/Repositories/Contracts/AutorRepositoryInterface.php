<?php

namespace App\Repositories\Contracts;

use App\Models\Autor;
use Illuminate\Database\Eloquent\Collection;
use JasonGuru\LaravelMakeRepository\Repository\RepositoryContract;

interface AutorRepositoryInterface extends RepositoryContract
{
    public function list(): Collection;

    public function update(array $data, Autor $autor): Autor;
}
