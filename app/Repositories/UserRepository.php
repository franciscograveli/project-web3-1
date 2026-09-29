<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
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

    public function list(): Collection
    {
        return $this->orderBy('name')->get();
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
