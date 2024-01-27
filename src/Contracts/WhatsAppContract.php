<?php

namespace Susheelbhai\WhatsApp\Contracts;

interface WhatsAppContract
{
    public function sendText(array $data);
    public function sendOTP(array $data);
    public function sendPdf(array $data);
    public function sendMedia(array $data);
}