<?php

namespace Susheelbhai\WhatsApp\Services\Facades;

use Illuminate\Support\Facades\Facade;

class WhatsApp extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'whatsapp';
    }

}