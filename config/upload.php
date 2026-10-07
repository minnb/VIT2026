<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Thu muc luu anh upload
    |--------------------------------------------------------------------------
    |
    | Truoc day checkFolderImage() goi thang env('APP_DIR_IMAGE'). Sau khi chay
    | `php artisan config:cache`, env() ngoai file config tra ve null -> mkdir(null)
    | va anh bi luu sai cho. Doc qua config de gia tri luon ton tai.
    |
    */

    'dir' => env('APP_DIR_IMAGE', 'storage/app/public/uploads/product'),

    /*
    | Anh dung khi ban ghi khong co anh nao.
    */
    'placeholder' => 'public/assets/images/logo.png',

    /*
    | Ten mien cu con nam trong noi dung CKEditor (posts.content).
    | Dung cho lenh `php artisan content:fix-image-urls`.
    */
    'legacy_domains' => [
        'http://vitduct.com.vn',
        'https://vitduct.com.vn',
        'http://www.vitduct.com.vn',
        'https://www.vitduct.com.vn',
    ],

];
