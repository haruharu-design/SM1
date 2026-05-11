<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Email notifikasi status pesanan
    |--------------------------------------------------------------------------
    |
    | Aktifkan setelah MAIL_* di .env diisi (misalnya SMTP Gmail).
    | Pengguna menerima email ke alamat akun mereka; opsional salinan ke admin.
    |
    */
    'mail_enabled' => (bool) env('ORDER_STATUS_MAIL_ENABLED', false),

    'bcc_admin' => (bool) env('ORDER_STATUS_MAIL_BCC_ADMIN', false),

    'admin_address' => env('ORDER_STATUS_MAIL_ADMIN_ADDRESS'),

];
