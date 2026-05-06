<?php

namespace App\Observers;

use App\Models\Order;
use App\Notifications\OrderStatusNotification;

class OrderObserver
{
    public function created(Order $order): void
    {
        $this->notifyStatusChange($order, null, $order->status);
    }

    public function updated(Order $order): void
    {
        if (! $order->wasChanged('status')) {
            return;
        }

        $this->notifyStatusChange($order, $order->getOriginal('status'), $order->status);
    }

    protected function notifyStatusChange(Order $order, ?string $oldStatus, string $newStatus): void
    {
        $user = $order->user;
        if (! $user) {
            return;
        }

        if ($newStatus === Order::STATUS_PROCESSING && $oldStatus !== Order::STATUS_PROCESSING) {
            $user->notify(new OrderStatusNotification($order, 'processing'));
        }

        if ($newStatus === Order::STATUS_COMPLETED && $oldStatus !== Order::STATUS_COMPLETED) {
            $user->notify(new OrderStatusNotification($order, 'completed'));
        }
    }
}
