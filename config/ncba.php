<?php

return [
    'env' => env('NCBA_ENV', 'sandbox'), // sandbox or production
    'debug' => env('NCBA_DEBUG', true),
    'sandbox' => [
        'api_key' => env('NCBA_SANDBOX_API_KEY', ''),
        'url' => 'https://devuat.ncbagroup.com/api',
        'legacy_url' => 'https://apidev.ncbagroup.com/api/v1',
    ],
    'production' => [
        'api_key' => env('NCBA_API_KEY', ''),
        'url' => 'https://ncbagroup.com/api',
        'legacy_url' => 'https://openbanking.api.ncbagroup.com/prod/openbankingapigateway/api/v1',
    ],
];