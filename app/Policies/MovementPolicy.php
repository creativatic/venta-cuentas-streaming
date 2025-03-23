<?php

namespace App\Policies;

use App\Models\Movement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MovementPolicy
{
    /**
     * Determina si el usuario puede ver la lista de movimientos.
     */
    public function viewAny(User $user): bool
    {
        // Solo los Super Admin y Admin pueden ver la lista de movimientos
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede ver un movimiento específico.
     */
    public function view(User $user, Movement $movement): bool
    {
        // Solo los Super Admin y Admin pueden ver movimientos
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede crear movimientos.
     */
    public function create(User $user): bool
    {
        // Solo los Super Admin y Admin pueden crear movimientos
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede actualizar un movimiento.
     */
    public function update(User $user, Movement $movement): bool
    {
        // Solo los Super Admin y Admin pueden actualizar movimientos
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede eliminar un movimiento.
     */
    public function delete(User $user, Movement $movement): bool
    {
        // Solo los Super Admin pueden eliminar movimientos
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede restaurar un movimiento eliminado.
     */
    public function restore(User $user, Movement $movement): bool
    {
        // Solo los Super Admin pueden restaurar movimientos
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un movimiento.
     */
    public function forceDelete(User $user, Movement $movement): bool
    {
        // Solo los Super Admin pueden eliminar movimientos permanentemente
        return $user->hasRole('Super Admin');
    }
}