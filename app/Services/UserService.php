<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function list(): Collection
    {
        return $this->userRepository->list();
    }

    public function create(array $data): User
    {
        /** @var User */
        return $this->userRepository->create($data);
    }

    public function update(array $data, User $user): User
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $this->userRepository->update($data, $user);
    }

    public function delete(User $user): bool
    {
        $user->tokens()->delete();

        return (bool) $this->userRepository->deleteById($user->id);
    }

    public function login(string $email, string $password): User
    {
        $user = $this->userRepository->findByEmail($email);

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais informadas estão incorretas.'],
            ]);
        }

        return $user;
    }
}
