<?php


return [
    'default_provider' => 'king_digital',
    'send_msg' => 1,
    'king_digital'=>[
        'end_point' => env('KING_END_POINT', ''),
        'token' => env('KING_DIGITAL_TOKEN', ''),
        'instance' => env('KING_DIGITAL_iNSTANCE', ''),
    ]
];