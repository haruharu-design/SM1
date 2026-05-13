<?php

namespace App\Notifications;

use App\Models\ProductQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ProductQuestionAnsweredNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ProductQuestion $question
    ) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if (filled($notifiable->email ?? null)) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Jawaban Q&A produk',
            'body' => 'Pertanyaan Anda pada produk '.$this->question->product->name.' telah dijawab admin.',
            'product_id' => $this->question->product_id,
            'question_id' => $this->question->id,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $productUrl = URL::route('products.show', $this->question->product_id, true);

        return (new MailMessage)
            ->subject('Jawaban Q&A Produk — '.$this->question->product->name)
            ->greeting('Halo, '.$notifiable->name.'.')
            ->line('Pertanyaan Anda sudah dijawab oleh admin.')
            ->line('Q: '.$this->question->question)
            ->line('A: '.$this->question->answer)
            ->action('Lihat produk', $productUrl)
            ->line('Terima kasih telah menggunakan '.config('app.name').'.');
    }
}
