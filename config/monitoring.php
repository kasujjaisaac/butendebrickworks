<?php

return [
    'slow_request_threshold_ms' => env('SLOW_REQUEST_THRESHOLD_MS', 1500),

    'talk_to_us' => [
        'per_minute' => env('TALK_TO_US_PER_MINUTE', 5),
        'per_hour' => env('TALK_TO_US_PER_HOUR', 30),
        'honeypot_field' => env('TALK_TO_US_HONEYPOT_FIELD', 'website'),
    ],
];
