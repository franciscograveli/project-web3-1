<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * O usuário só pode alterar a própria conta.
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * O usuário só pode excluir a própria conta.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
}
