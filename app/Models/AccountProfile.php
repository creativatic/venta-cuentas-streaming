<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountProfile extends Model
{
    use HasFactory;

    protected $table = 'account_profiles';

    protected $fillable = [
        'profile_number',
        'profile_name',
        'profile_pin',
        'price',
        'status_profile',
        'accounts_id',
    ];
    // Opcional: Conversiones de tipos
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con la tabla accounts (uno a muchos inverso)
    public function account()
    {
        return $this->belongsTo(Account::class, 'accounts_id');
    }
    public function paysProfiles(): HasMany
    {
        return $this->hasMany(PaysProfile::class, 'account_profile_id');
    }
}