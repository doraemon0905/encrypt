<?php
return [
    'private_key' => env('ENCRYPT_PRIVATE_KEY', storage_path('oauth-private.key')),
    'aes_key' => env('ENCRYPT_AES_KEY', ''),
    'aes_iv' => env('ENCRYPT_AES_IV', ''),
    'aes_method' => env('ENCRYPT_AES_METHOD', 'AES-256-CBC'),
];
