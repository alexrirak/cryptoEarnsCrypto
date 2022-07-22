<?php

return [

    'celsius_url' => env('CELSIUS_URL', 'https://wallet-api.celsius.network/util/interest/rates'),
    'celsius_staging_url' => env('CELSIUS_STAGING_URL', 'https://wallet-api.staging.celsius.network/util/interest/rates'),
    'celsius_special_rate' => env('CELSIUS_SPECIAL_RATE',  1.25),
    'celsius_source_id' => env('CELSIUS_SOURCE_ID',  'celsius'),
];
