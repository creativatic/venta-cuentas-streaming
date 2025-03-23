<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;

class RolePolicy
{
    /**
     * Determina si el usuario puede ver la lista de roles.
     */
    public function viewAny(User $user)
    {
        // Solo los Super Admin pueden ver la lista de roles
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede ver un rol específico.
     */
    public function view(User $user, Role $role)
    {
        // Solo los Super Admin pueden ver roles
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede crear nuevos roles.
     */
    public function create(User $user)
    {
        // Solo los Super Admin pueden crear roles
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede actualizar un rol.
     */
    public function update(User $user, Role $role)
    {
        // Solo los Super Admin pueden actualizar roles
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede eliminar un rol.
     */
    public function delete(User $user, Role $role)
    {
        // Solo los Super Admin pueden eliminar roles
        return $user->hasRole('Super Admin');
    }
}