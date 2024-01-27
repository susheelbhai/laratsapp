<?php

namespace Susheelbhai\WhatsApp\Services;

use Susheelbhai\WhatsApp\Contracts\WhatsAppContract;

class WhatsAppService 
{
    protected $whatsAppRepo;

    public function __construct(
        WhatsAppContract $whatsAppRepo
    ) {
        $this->whatsAppRepo = $whatsAppRepo;
    }
    public function sendText($data)
    {
        return $this->whatsAppRepo->sendText($data);
    }
    public function sendOTP($data)
    {
        return $this->whatsAppRepo->sendOTP($data);
    }
    public function sendPdf($data)
    {
        return $this->whatsAppRepo->sendPdf($data);
    }
    public function sendMedia($data)
    {
        return $this->whatsAppRepo->sendMedia($data);
    }
}
