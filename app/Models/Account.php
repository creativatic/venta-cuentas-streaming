<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'services_id',
        'name_account',
        'email_account',
        'pass_account',
        'type_account', // Nuevo campo
        'price',
        'available_profiles', // Nuevo campo
        'used_profiles', // Nuevo campo
        'total_profiles', // Mantenido (si aún es necesario)
        'date_pay',
        'renewal_date_account',
        'status',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'accounts_clients', 'accounts_id', 'clients_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'services_id');
    }

    public function accountProfiles()
    {
        return $this->hasMany(AccountProfile::class, 'accounts_id');
    }
    
}