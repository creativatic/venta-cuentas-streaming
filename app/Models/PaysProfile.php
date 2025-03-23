<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaysProfile extends Model
{
    protected $table = 'pays_profile'; // Especifica el nombre de la tabla

    protected $fillable = [
        'pay',
        'total_pay',
        'next_pay',
        'date_pay',
        'next_date_pay',
        'renewal_date_profile',
        'status_profile',
        'description',
        'account_profile_id',
    ];

    public function accountProfile(): BelongsTo
    {
        return $this->belongsTo(AccountProfile::class, 'account_profile_id');
    }
    public function paymentNotifications(): HasMany
    {
        return $this->hasMany(PaymentNotification::class, 'pays_profile_id');
    }
}