<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use JasonGuru\LaravelMakeRepository\Repository\RepositoryContract;

interface UserRepositoryInterface extends RepositoryContract
{
    public function list(): Collection;

    public function findByEmail(string $email): ?User;

    public function update(array $data, User $user): User;
}
