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
        $data = $this->updateData($data);
        return $this->whatsAppRepo->sendText($data);
    }
    public function sendOTP($data)
    {
        $data = $this->updateData($data);
        return $this->whatsAppRepo->sendOTP($data);
    }
    public function sendPdf($data)
    {
        $data = $this->updateData($data);
        return $this->whatsAppRepo->sendPdf($data);
    }
    public function sendMedia($data)
    {
        $data = $this->updateData($data);
        return $this->whatsAppRepo->sendMedia($data);
    }

    protected function updateData($data) {
        if (config('app.env') != 'production') {
            $data['message'] .= ' sent to '.$data['phone'];
            $data['phone'] = '91'.config('whatsapp.whatsapp_test_number');
        }
        return $data;
    }
}
