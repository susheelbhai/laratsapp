<?php


return [
    'default_provider' => 'sms4power',
    'send_msg' => 1,
    'king_digital'=>[
        'end_point' => env('WHATSAPP_END_POINT', ''),
        'token' => env('WHATSAPP_TOKEN', ''),
        'instance' => env('WHATSAPP_iNSTANCE', ''),
    ],
    'sms4power'=>[
        'end_point' => env('SMS4POWER_END_POINT', ''),
        'api_key' => env('SMS4POWER_API_KEY', ''),
    ],
];