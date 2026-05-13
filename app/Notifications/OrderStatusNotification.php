<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class OrderStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $event
    ) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if (config('order_notifications.mail_enabled') && filled($notifiable->email ?? null)) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toDatabase(object $notifiable): array
    {
        return $this->payloadForChannels();
    }

    public function toMail(object $notifiable): MailMessage
    {
        $payload = $this->payloadForChannels();
        $orderUrl = URL::route('orders.show', $this->order, true);

        $message = (new MailMessage)
            ->subject($payload['title'].' — '.$this->order->order_number)
            ->greeting('Halo, '.$notifiable->name.'.')
            ->line($payload['body'])
            ->action('Lihat detail pesanan', $orderUrl)
            ->line('Terima kasih telah berbelanja di '.config('app.name').'.');

        if (config('order_notifications.bcc_admin') && filled(config('order_notifications.admin_address'))) {
            $message->bcc((string) config('order_notifications.admin_address'));
        }

        return $message;
    }

    /**
     * @return array{title: string, body: string, order_id: int}
     */
    protected function payloadForChannels(): array
    {
        $no = $this->order->order_number;

        return match ($this->event) {
            'awaiting_payment' => [
                'title' => 'Menunggu pembayaran',
                'body' => 'Pesanan '.$no.' telah dibuat. Silakan transfer sesuai nominal ke rekening di halaman detail pesanan. Setelah transfer, tekan tombol «Sudah selesai bayar» agar admin dapat memverifikasi pembayaran Anda.',
                'order_id' => $this->order->id,
            ],
            'awaiting_transfer_confirmation' => [
                'title' => 'Menunggu konfirmasi pembayaran',
                'body' => 'Anda sudah menandai selesai bayar untuk pesanan '.$no.'. Pembayaran akan dicek oleh admin; Anda akan menerima notifikasi setelah pembayaran diverifikasi.',
                'order_id' => $this->order->id,
            ],
            'payment_verified' => [
                'title' => 'Pembayaran berhasil',
                'body' => 'Pembayaran pesanan '.$no.' telah dikonfirmasi admin. Pesanan Anda sedang diproses.',
                'order_id' => $this->order->id,
            ],
            'processing' => [
                'title' => 'Pesanan diproses',
                'body' => 'Pesanan '.$no.' sedang diproses oleh tim kami.',
                'order_id' => $this->order->id,
            ],
            'shipped' => [
                'title' => 'Pesanan dikirim',
                'body' => 'Pesanan '.$no.' sedang dalam pengiriman.'.($this->order->tracking_number ? ' No. resi: '.$this->order->tracking_number.'.' : ''),
                'order_id' => $this->order->id,
            ],
            'completed' => [
                'title' => 'Pesanan selesai',
                'body' => 'Pesanan '.$no.' telah selesai. Silakan berikan ulasan untuk produk yang Anda beli.',
                'order_id' => $this->order->id,
            ],
            'cancelled' => [
                'title' => 'Pesanan dibatalkan',
                'body' => 'Pesanan '.$no.' telah dibatalkan.',
                'order_id' => $this->order->id,
            ],
            'order_received' => [
                'title' => 'Pesanan diterima',
                'body' => 'Kami telah mencatat pesanan '.$no.'.',
                'order_id' => $this->order->id,
            ],
            default => [
                'title' => 'Update pesanan',
                'body' => 'Ada pembaruan untuk pesanan '.$no.'.',
                'order_id' => $this->order->id,
            ],
        };
    }
}
