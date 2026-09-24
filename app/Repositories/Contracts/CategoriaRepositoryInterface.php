<?php

namespace App\Repositories\Contracts;

use JasonGuru\LaravelMakeRepository\Repository\RepositoryContract;

interface CategoriaRepositoryInterface extends RepositoryContract
{
    public function list();
}
