<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price_services',
        'individually_price_services',
        'service_profiles', // Corregido: Cambiado de 'profiles' a 'service_profiles'
        'link',
        'description',
        'image',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'services_id');
    }

}
