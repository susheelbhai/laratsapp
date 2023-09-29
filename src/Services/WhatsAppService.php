<?php


namespace Susheelbhai\WhatsApp\Services;

use Susheelbhai\WhatsApp\Repository\KingDigital;


class WhatsAppService
{

    public function sendText($data)
    {
        $repo = new KingDigital();
        return $repo->sendText($data);
    }
    public function sendOTP($data)
    {
        $repo = new KingDigital();
        return $repo->sendOTP($data);
    }
    public function sendMedia($data)
    {
        $repo = new KingDigital();
        return $repo->sendMedia($data);
    }
}
