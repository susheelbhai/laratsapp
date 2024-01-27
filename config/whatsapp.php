<?php


return [
    'default_provider' => 'sms4power',
    'send_msg' => 1,
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