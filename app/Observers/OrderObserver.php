<?php

namespace App\Observers;

use App\Models\Order;
use App\Notifications\OrderStatusNotification;

class OrderObserver
{
    public function created(Order $order): void
    {
        $this->notifyUser($order, null, $order->status, true);
    }

    public function updated(Order $order): void
    {
        if (! $order->wasChanged('status')) {
            return;
        }

        $this->notifyUser($order, $order->getOriginal('status'), $order->status, false);
    }

    protected function notifyUser(Order $order, ?string $oldStatus, string $newStatus, bool $isCreate): void
    {
        $user = $order->user;
        if (! $user) {
            return;
        }

        $event = $this->resolveNotificationEvent($isCreate, $oldStatus, $newStatus);
        if ($event === null) {
            return;
        }

        $user->notify(new OrderStatusNotification($order, $event));
    }

    protected function resolveNotificationEvent(bool $isCreate, ?string $oldStatus, string $newStatus): ?string
    {
        if ($isCreate) {
            return match ($newStatus) {
                Order::STATUS_WAITING_PAYMENT => 'awaiting_payment',
                Order::STATUS_PROCESSING => 'processing',
                default => 'order_received',
            };
        }

        if ($oldStatus === $newStatus) {
            return null;
        }

        return match ($newStatus) {
            Order::STATUS_WAITING_PAYMENT => 'awaiting_payment',
            Order::STATUS_PROCESSING => 'processing',
            Order::STATUS_SHIPPED => 'shipped',
            Order::STATUS_COMPLETED => 'completed',
            Order::STATUS_CANCELLED => 'cancelled',
            default => null,
        };
    }
}
