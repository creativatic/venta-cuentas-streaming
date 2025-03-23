<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Service;

class ServicePolicy
{
    /**
     * Determina si el usuario puede ver la lista de servicios.
     */
    public function viewAny(User $user): bool
    {
        // Solo los Super Admin y Admin pueden ver la lista de servicios
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede ver un servicio específico.
     */
    public function view(User $user, Service $service): bool
    {
        // Solo los Super Admin y Admin pueden ver servicios
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede crear servicios.
     */
    public function create(User $user): bool
    {
        // Solo los Super Admin y Admin pueden crear servicios
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede actualizar un servicio.
     */
    public function update(User $user, Service $service): bool
    {
        // Solo los Super Admin y Admin pueden actualizar servicios
        return $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determina si el usuario puede eliminar un servicio.
     */
    public function delete(User $user, Service $service): bool
    {
        // Solo los Super Admin pueden eliminar servicios
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede restaurar un servicio eliminado.
     */
    public function restore(User $user, Service $service): bool
    {
        // Solo los Super Admin pueden restaurar servicios
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un servicio.
     */
    public function forceDelete(User $user, Service $service): bool
    {
        // Solo los Super Admin pueden eliminar servicios permanentemente
        return $user->hasRole('Super Admin');
    }
}