<?php

return [

    'celsius_url' => env('CELSIUS_URL', 'https://wallet-api.celsius.network/util/interest/rates'),
    'celsius_staging_url' => env('CELSIUS_STAGING_URL', 'https://wallet-api.staging.celsius.network/util/interest/rates'),
    'celsius_special_rate' => env('CELSIUS_SPECIAL_RATE',  1.25),
    'celsius_source_id' => env('CELSIUS_SOURCE_ID',  'celsius'),
    'gemini_url' => env('GEMINI_URL', 'https://www.gemini.com/_next/data/lAYVLJN5wKe5IZYvty28D/en-US/earn.json'),
    'gemini_source_id' => env('GEMINI_SOURCE_ID',  'gemini'),
];
