<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderStatusNotification;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product', 'payments.bankAccount']);

        return view('orders.show', compact('order'));
    }

    /**
     * Pembeli menandai sudah transfer (setelah transfer manual ke rekening).
     */
    public function markBankTransferComplete(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $payment = $order->getPendingBankTransferPayment();
        if (! $payment) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Tidak ada pembayaran transfer yang dapat ditandai untuk pesanan ini.');
        }

        try {
            $payment->markTransferReportedByCustomer();
            $user = $order->user;
            if ($user) {
                $user->notify(new OrderStatusNotification($order, 'awaiting_transfer_confirmation'));
            }

            return redirect()->route('orders.show', $order)
                ->with('success', 'Terima kasih. Pembayaran Anda ditandai menunggu verifikasi admin.');
        } catch (\Throwable $e) {
            return redirect()->route('orders.show', $order)
                ->with('error', $e->getMessage() ?: 'Gagal memperbarui status pembayaran.');
        }
    }
}
