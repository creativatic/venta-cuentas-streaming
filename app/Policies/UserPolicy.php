<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determina si el usuario puede ver la lista de usuarios.
     */
    public function viewAny(User $user)
    {
        // Solo los Super Admin y Admin pueden ver la lista de usuarios
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede ver un usuario específico.
     */
    public function view(User $user, User $model)
    {
        // Un usuario solo puede ver su propio perfil, a menos que sea Super Admin o Admin
        return $user->id === $model->id || $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede crear nuevos usuarios.
     */
    public function create(User $user)
    {
        // Solo los Super Admin pueden crear nuevos usuarios
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede actualizar un usuario.
     */
    public function update(User $user, User $model)
    {
        // Un usuario solo puede actualizar su propio perfil, a menos que sea Super Admin
        return $user->id === $model->id || $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede eliminar un usuario.
     */
    public function delete(User $currentUser, User $userToDelete): bool
    {
        // Evitar que se elimine el Super Admin
        if ($userToDelete->email === 'admin@gmail.com') { // Cambia 'admin@gmail.com' por el email del Super Admin
            return false;
        }

        // Solo los Super Admin pueden eliminar usuarios
        return $currentUser->hasRole('Super Admin');
    }
}