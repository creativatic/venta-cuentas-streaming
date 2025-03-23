<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Company;

class CompanyPolicy
{
    /**
     * Determina si el usuario puede ver la lista de empresas.
     */
    public function viewAny(User $user)
    {
        // Solo los Super Admin pueden ver la lista de empresas
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede ver una empresa específica.
     */
    public function view(User $user, Company $company)
    {
        // Un usuario solo puede ver su propia empresa, a menos que sea Super Admin
        return $user->company_id === $company->id || $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede crear nuevas empresas.
     */
    public function create(User $user)
    {
        // Solo los Super Admin pueden crear empresas
        return $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede actualizar una empresa.
     */
    public function update(User $user, Company $company)
    {
        // Un usuario solo puede actualizar su propia empresa, a menos que sea Super Admin
        return $user->company_id === $company->id || $user->hasRole('Super Admin');
    }

    /**
     * Determina si el usuario puede eliminar una empresa.
     */
    public function delete(User $user, Company $company)
    {
        // Solo los Super Admin pueden eliminar empresas
        return $user->hasRole('Super Admin');
    }
}