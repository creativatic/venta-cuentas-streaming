<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountPayment extends Model
{
    protected $fillable = [
        'accounts_id',
        'igv',
        'pay',
        'total_pay',
        'next_pay',
        'date_pay',
        'next_date_pay',
        'status',
        'description',
    ];

    /**
     * Relación con la tabla payment_notification.
     */
    public function paymentNotifications(): HasMany
    {
        return $this->hasMany(PaymentNotification::class, 'account_payment_id');
    }
}