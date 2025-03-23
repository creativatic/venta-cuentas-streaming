<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; // Roles spatie que no uso


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id', // Asegúrate de incluir company_id en fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Relación con el modelo Company (pertenece a una compañía).
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    // Método de conveniencia para comprobar roles
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('title', $role);
        }
        
        if (is_array($role)) {
            foreach ($role as $r) {
                if ($this->hasRole($r)) {
                    return true;
                }
            }
            return false;
        }
        
        // Si $role es un objeto Role o una colección
        return $role->intersect($this->roles)->count() > 0;
    }

    // Método para comprobar permisos
    public function hasPermission($permission)
    {
        // Cargamos los roles y permisos solo una vez
        if (!isset($this->permissionsCache)) {
            $this->permissionsCache = $this->roles()->with('permissions')->get()
                ->flatMap(function ($role) {
                    return $role->permissions;
                })
                ->pluck('title');
        }
        
        return $this->permissionsCache->contains($permission);
    }

    
}
