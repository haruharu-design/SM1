<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        // Pembayaran transfer: status `confirmed` setelah admin verifikasi (bukan `paid`).
        $confirmedTransfer = Payment::query()
            ->where('status', Payment::STATUS_CONFIRMED)
            ->sum('amount');

        // COD: catatan pembayaran tetap `pending` sampai tidak di-update; hitung dari pesanan selesai.
        $codCompleted = Payment::query()
            ->where('method', Payment::METHOD_COD)
            ->whereHas('order', fn ($q) => $q->where('status', Order::STATUS_COMPLETED))
            ->sum('amount');

        $totalRevenue = (float) $confirmedTransfer + (float) $codCompleted;

        return [
            Stat::make('Total User', $totalUsers)
                ->description('Pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Total Order', $totalOrders)
                ->description('Seluruh pesanan')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info'),
            Stat::make('Total Pendapatan', 'Rp '.number_format($totalRevenue, 0, ',', '.'))
                ->description('Dari pembayaran berhasil')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}
