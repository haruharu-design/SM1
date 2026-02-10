<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOrderAfterPaymentConfirmed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Order $order
    ) {}

    /**
     * Delay beberapa detik untuk simulasi otomatisasi.
     */
    public $delay = 5;

    public function handle(): void
    {
        $this->order->update([
            'status' => Order::STATUS_PROCESSING,
        ]);
    }
}
