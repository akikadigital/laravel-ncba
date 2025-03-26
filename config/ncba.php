<?php

return [
    'env' => env('NCBA_ENV', 'sandbox'), // sandbox or production
    'debug' => env('NCBA_DEBUG', true),
    'sandbox' => [
        'api_key' => env('NCBA_SANDBOX_API_KEY', 'T3st123'),
        'url' => 'https://devuat.ncbagroup.com/api',
    ],
    'production' => [
        'api_key' => env('NCBA_API_KEY', 'T3st123'),
        'url' => 'https://ncbagroup.com/api',
    ],
];
