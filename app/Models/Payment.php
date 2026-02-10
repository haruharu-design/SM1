<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'bank_id',
        'status',
        'reference_id',
        'gateway_response',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    /** Metode pembayaran */
    public const METHOD_COD = 'cod';
    public const METHOD_BANK_TRANSFER = 'bank_transfer';

    /** Status pembayaran */
    public const STATUS_PENDING = 'pending';
    public const STATUS_AWAITING_CONFIRMATION = 'awaiting_confirmation';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_FAILED = 'failed';

    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_AWAITING_CONFIRMATION => 'Menunggu Konfirmasi',
            self::STATUS_CONFIRMED => 'Terkonfirmasi',
            self::STATUS_FAILED => 'Gagal',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }
}
