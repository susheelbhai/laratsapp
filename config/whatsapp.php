<?php


return [
    'default_provider' => 'general_unofficial',
    'send_msg' => env('SEND_WHATSAPP_MSG', 0),
    'whatsapp_test_number' => env('WHATSAPP_TEST_NUMBER', '9999999999'),
    'general_unofficial'=>[
        'end_point' => env('WHATSAPP_END_POINT', ''),
        'token' => env('WHATSAPP_API_KEY', ''),
        'instance' => env('WHATSAPP_API_KEY2', ''),
    ],
    'king_digital'=>[
        'end_point' => env('WHATSAPP_END_POINT', ''),
        'token' => env('WHATSAPP_API_KEY', ''),
        'instance' => env('WHATSAPP_API_KEY2', ''),
    ],
    'sms4power'=>[
        'end_point' => env('WHATSAPP_END_POINT', ''),
        'api_key' => env('WHATSAPP_API_KEY', ''),
    ],
];