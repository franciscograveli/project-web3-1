<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Return the fully-qualified model class name.
     */
    public function model(): string
    {
        return User::class;
    }

    public function list(int $perPage): LengthAwarePaginator
    {
        return $this->orderBy('name')->paginate($perPage);
    }

    public function findByEmail(string $email): ?User
    {
        /** @var User|null */
        return $this->getByColumn($email, 'email');
    }

    public function update(array $data, User $user): User
    {
        /** @var User */
        return $this->updateById($user->id, $data);
    }
}
