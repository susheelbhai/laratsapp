<?php

$endPoint = env('WHATSAPP_END_POINT', '');

return [
    // When the endpoint is "mock", route sends through the Mock provider which
    // captures messages into a browser-viewable inbox (/whatsapp_mock) instead
    // of calling a real WhatsApp API — useful for local development/testing.
    'default_provider' => $endPoint === 'mock' ? 'mock' : 'general_unofficial',
    'send_msg' => env('SEND_WHATSAPP_MSG', 0),
    'whatsapp_test_number' => env('WHATSAPP_TEST_NUMBER', '9999999999'),
    'general_unofficial' => [
        'end_point' => $endPoint,
        'token' => env('WHATSAPP_API_KEY', ''),
        'instance' => env('WHATSAPP_API_KEY2', ''),
    ],
    'king_digital' => [
        'end_point' => $endPoint,
        'token' => env('WHATSAPP_API_KEY', ''),
        'instance' => env('WHATSAPP_API_KEY2', ''),
    ],
    'sms4power' => [
        'end_point' => $endPoint,
        'api_key' => env('WHATSAPP_API_KEY', ''),
    ],
];
