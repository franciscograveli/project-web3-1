<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use JasonGuru\LaravelMakeRepository\Repository\RepositoryContract;

interface UserRepositoryInterface extends RepositoryContract
{
    public function list(int $perPage): LengthAwarePaginator;

    public function findByEmail(string $email): ?User;

    public function update(array $data, User $user): User;
}
