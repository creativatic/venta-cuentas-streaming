<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class ClientPolicy
{
    /**
     * Determina si el usuario puede ver la lista de clientes.
     */
    public function viewAny(User $user): bool
    {
        // Solo los Super Admin y Admin pueden ver la lista de clientes
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede ver un cliente específico.
     */
    public function view(User $user, Client $client): bool
    {
        // Solo los Super Admin y Admin pueden ver clientes
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede crear clientes.
     */
    public function create(User $user): bool
    {
        // Solo los Super Admin y Admin pueden crear clientes
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede actualizar un cliente.
     */
    public function update(User $user, Client $client): bool
    {
        // Solo los Super Admin y Admin pueden actualizar clientes
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede eliminar un cliente.
     */
    public function delete(User $user, Client $client): bool
    {
        // Solo los Super Admin pueden eliminar clientes
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede restaurar un cliente eliminado.
     */
    public function restore(User $user, Client $client): bool
    {
        // Solo los Super Admin pueden restaurar clientes
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un cliente.
     */
    public function forceDelete(User $user, Client $client): bool
    {
        // Solo los Super Admin pueden eliminar clientes permanentemente
        return $user->hasRole('Super Admin');
    }
}