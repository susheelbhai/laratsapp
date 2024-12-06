<?php


return [
    'default_provider' => 'general_unofficial',
    'send_msg' => 1,
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