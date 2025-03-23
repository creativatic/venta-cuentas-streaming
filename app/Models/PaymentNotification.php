<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentNotification extends Model
{
    protected $fillable = [
        'type_notification',
        'notification_first',
        'notification_second',
        'notification_third',
        'notification_fourth',
        'notification_pay',
        'notification_email',
        'notification_phone',
        'notification_status',
        'notification_description',
        'account_payment_id',
        'pays_profile_id',
    ];

    /**
     * Relación con la tabla account_payments.
     */
    public function accountPayment(): BelongsTo
    {
        return $this->belongsTo(AccountPayment::class, 'account_payment_id');
    }

    /**
     * Relación con la tabla pays_profile.
     */
    public function paysProfile(): BelongsTo
    {
        return $this->belongsTo(PaysProfile::class, 'pays_profile_id');
    }
}