<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $kind
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return match ($this->kind) {
            'processing' => [
                'title' => 'Pesanan sedang diproses',
                'body' => 'Pesanan '.$this->order->order_number.' sedang diproses oleh tim kami.',
                'order_id' => $this->order->id,
            ],
            'completed' => [
                'title' => 'Pesanan selesai',
                'body' => 'Pesanan '.$this->order->order_number.' telah selesai. Silakan berikan ulasan untuk produk yang Anda beli.',
                'order_id' => $this->order->id,
            ],
        };
    }
}
