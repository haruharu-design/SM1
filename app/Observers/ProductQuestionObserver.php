<?php

namespace App\Observers;

use App\Models\ProductQuestion;
use App\Notifications\ProductQuestionAnsweredNotification;

class ProductQuestionObserver
{
    public function updated(ProductQuestion $productQuestion): void
    {
        if (! $productQuestion->wasChanged('answer')) {
            return;
        }

        if (blank($productQuestion->answer) || ! $productQuestion->user) {
            return;
        }

        $productQuestion->user->notify(new ProductQuestionAnsweredNotification(
            $productQuestion->loadMissing('product')
        ));
    }
}
