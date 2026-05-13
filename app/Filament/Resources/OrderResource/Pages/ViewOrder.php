<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('confirmPayment')
                ->label('Konfirmasi pembayaran')
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi pembayaran transfer?')
                ->modalDescription('Hanya jika pembeli sudah menandai selesai bayar. Pastikan transfer sudah masuk. Pesanan akan diproses setelah konfirmasi.')
                ->visible(fn (): bool => $this->record->awaitsAdminBankTransferConfirmation())
                ->action(function (): void {
                    $payment = $this->record->getAwaitingBankTransferPayment();
                    if (! $payment) {
                        Notification::make()->title('Gagal')->body('Tidak ada pembayaran yang menunggu konfirmasi.')->danger()->send();

                        return;
                    }

                    try {
                        $payment->confirmFromAdmin();
                        Notification::make()->title('Pembayaran dikonfirmasi')->body('Job pemrosesan pesanan telah dijadwalkan.')->success()->send();
                    } catch (\Throwable $e) {
                        Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                    }
                }),
            Actions\EditAction::make(),
        ];
    }
}
