<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'discount',
        'total',
        'status',
        'shipping_address',
        'shipping_phone',
        'tracking_number',
        'coupon_code',
        'discount_code',
        'distance_km',
        'shipping_cost',
        'shipping_lat',
        'shipping_lng',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
            'distance_km' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'shipping_lat' => 'decimal:8',
            'shipping_lng' => 'decimal:8',
        ];
    }

    /** Status pesanan */
    public const STATUS_WAITING_PAYMENT = 'menunggu_pembayaran';

    public const STATUS_PROCESSING = 'diproses';

    public const STATUS_SHIPPED = 'dikirim';

    public const STATUS_COMPLETED = 'selesai';

    public const STATUS_CANCELLED = 'dibatalkan';

    /** Legacy aliases untuk kompatibilitas */
    public const STATUS_PENDING = self::STATUS_WAITING_PAYMENT;

    public const STATUS_CONFIRMED = self::STATUS_PROCESSING;

    public const STATUS_PICKED_UP = self::STATUS_SHIPPED;

    public const STATUS_ON_DELIVERY = self::STATUS_SHIPPED;

    public const STATUS_DELIVERED = self::STATUS_COMPLETED;

    public static function statusOptions(): array
    {
        return [
            self::STATUS_WAITING_PAYMENT => 'Menunggu Pembayaran',
            self::STATUS_PROCESSING => 'Diproses',
            self::STATUS_SHIPPED => 'Dikirim',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $last = static::whereDate('created_at', today())->count() + 1;

        return $prefix.$date.str_pad((string) $last, 4, '0', STR_PAD_LEFT);
    }

    /** Order transfer bank menunggu admin konfirmasi pembayaran */
    public function awaitsAdminBankTransferConfirmation(): bool
    {
        return $this->status === self::STATUS_WAITING_PAYMENT
            && $this->payments()
                ->where('status', Payment::STATUS_AWAITING_CONFIRMATION)
                ->where('method', Payment::METHOD_BANK_TRANSFER)
                ->exists();
    }

    public function getAwaitingBankTransferPayment(): ?Payment
    {
        return $this->payments()
            ->where('status', Payment::STATUS_AWAITING_CONFIRMATION)
            ->where('method', Payment::METHOD_BANK_TRANSFER)
            ->first();
    }

    /** Total penghematan dari diskon persen per produk (bukan voucher). */
    public function productDiscountSaved(): float
    {
        return round((float) $this->items->sum(function (OrderItem $item): float {
            $list = $item->list_unit_price !== null ? (float) $item->list_unit_price : (float) $item->unit_price;

            return max(0.0, $list * (int) $item->quantity - (float) $item->total_price);
        }), 2);
    }
}
