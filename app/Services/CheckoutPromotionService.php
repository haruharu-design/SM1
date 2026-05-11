<?php

namespace App\Services;

use App\Models\Coupon;

class CheckoutPromotionService
{
    public const KIND_VOUCHER = 'voucher';

    /**
     * Potongan voucher (kode) pada subtotal barang — diskon per produk dihitung terpisah lewat harga jual.
     *
     * Harus dipanggil dari dalam DB::transaction agar lockForUpdate berlaku.
     *
     * @return array{
     *   success: bool,
     *   message?: string,
     *   voucher_amount: float,
     *   total_off: float,
     *   voucher_code: ?string,
     *   coupons_to_increment: list<int>
     * }
     */
    public function applyVoucher(float $subtotal, ?string $voucherCode): array
    {
        $voucherCode = $this->normalizeCode($voucherCode);

        if ($voucherCode === null) {
            return [
                'success' => true,
                'voucher_amount' => 0.0,
                'total_off' => 0.0,
                'voucher_code' => null,
                'coupons_to_increment' => [],
            ];
        }

        $coupon = Coupon::query()
            ->where('code', $voucherCode)
            ->where('kind', self::KIND_VOUCHER)
            ->lockForUpdate()
            ->first();

        $err = $this->validateCoupon($coupon, $subtotal);
        if ($err !== null) {
            return $this->failure($err);
        }

        $voucherAmount = $this->amountForCoupon($coupon, $subtotal);

        return [
            'success' => true,
            'voucher_amount' => round($voucherAmount, 2),
            'total_off' => round(min($subtotal, $voucherAmount), 2),
            'voucher_code' => $voucherCode,
            'coupons_to_increment' => [$coupon->id],
        ];
    }

    /**
     * @param  list<int>  $couponIds
     */
    public function incrementCouponUsage(array $couponIds): void
    {
        $couponIds = array_values(array_unique(array_filter($couponIds)));
        if ($couponIds === []) {
            return;
        }

        Coupon::query()->whereIn('id', $couponIds)->lockForUpdate()->get();

        foreach ($couponIds as $id) {
            Coupon::query()->whereKey($id)->increment('used_count');
        }
    }

    protected function normalizeCode(?string $code): ?string
    {
        if ($code === null || trim($code) === '') {
            return null;
        }

        return strtoupper(trim($code));
    }

    protected function validateCoupon(?Coupon $coupon, float $subtotal): ?string
    {
        if (! $coupon) {
            return 'Kode voucher tidak ditemukan.';
        }

        if (! $coupon->is_active) {
            return 'Kode '.$coupon->code.' tidak aktif.';
        }

        if ($coupon->valid_from && now()->lt($coupon->valid_from)) {
            return 'Kode '.$coupon->code.' belum berlaku.';
        }

        if ($coupon->valid_until && now()->gt($coupon->valid_until)) {
            return 'Kode '.$coupon->code.' sudah kedaluwarsa.';
        }

        if ($coupon->min_purchase !== null && $subtotal < (float) $coupon->min_purchase) {
            return 'Minimum belanja untuk kode ini Rp '.number_format((float) $coupon->min_purchase, 0, ',', '.').'.';
        }

        if ($coupon->max_usage !== null && $coupon->used_count >= $coupon->max_usage) {
            return 'Kode '.$coupon->code.' sudah habis dipakai.';
        }

        return null;
    }

    protected function amountForCoupon(Coupon $coupon, float $base): float
    {
        if ($base <= 0) {
            return 0.0;
        }

        if ($coupon->type === 'percentage') {
            $pct = min(100, max(0, (float) $coupon->value));

            return round(min($base, $base * ($pct / 100)), 2);
        }

        return round(min($base, (float) $coupon->value), 2);
    }

    /**
     * @return array{success: false, message: string, voucher_amount: float, total_off: float, voucher_code: null, coupons_to_increment: array}
     */
    protected function failure(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
            'voucher_amount' => 0.0,
            'total_off' => 0.0,
            'voucher_code' => null,
            'coupons_to_increment' => [],
        ];
    }
}
