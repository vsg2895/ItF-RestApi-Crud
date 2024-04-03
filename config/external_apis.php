<?php

return [
    'country_codes' => [
        'base_url' => env('CC_URL', 'http://country.io/continent.json'),
    ],

    'timezone' => [
        'base_url' => env('TZ_URL', 'http://worldtimeapi.org/api/timezone'),
    ],

    'result_caching_expiration' => 18000
];

