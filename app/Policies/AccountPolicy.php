<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AccountPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        if (!$user->hasRole(['Super Admin', 'Admin', 'Gerente'])) {
            abort(403, 'No tienes permiso para ver la lista de cuentas ya fue pe.');
        }

        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Account $account): bool
    {
        // Solo los Super Admin pueden ver la lista de cuentas streaming
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo los Super Admin pueden create la lista de cuentas streaming
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Account $account): bool
    {
        // Solo los Super Admin pueden update la lista de cuentas streaming
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Account $account): bool
    {
        // Solo los Super Admin pueden delete la lista de cuentas streaming
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Account $account): bool
    {
        // Solo los Super Admin pueden restore la lista de cuentas streaming
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Account $account): bool
    {
        // Solo los Super Admin pueden forceDelete la lista de cuentas streaming
        return $user->hasRole('Super Admin');
    }
}
