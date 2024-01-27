<?php

namespace Susheelbhai\WhatsApp\Repository;

use Illuminate\Support\Facades\Http;
use Susheelbhai\WhatsApp\Contracts\WhatsAppContract;

class KingDigital implements WhatsAppContract
{
    public $token;
    public $instance;
    public $end_point;
    public function __construct()
    {
        $this->token = config('whatsapp.king_digital.token');
        $this->instance = config('whatsapp.king_digital.instance');
        $this->end_point = config('whatsapp.king_digital.end_point');
    }
    public function sendText($data)
    {
        $url = "{$this->end_point}?type=text-message&token={$this->token}&instance={$this->instance}&phone={$data['phone']}&message={$data['message']}";
        return $this->action($url);
    }
    public function sendOTP($data)
    {
        $message = "OTP to validate mobile no. for " . config('app.name') . " is " . $data['message'] . "  OTPs are SECRET. DO NOT disclose it to anyone. We NEVER asks for OTP on phone.";
        $url = "{$this->end_point}?type=text-message&token={$this->token}&instance={$this->instance}&phone={$data['phone']}&message={$message}";
        return $this->action($url);
    }
    public function sendMedia($data)
    {
        $message = $data['message'];
        $url = "{$this->end_point}?type=media-message&token={$this->token}&instance={$this->instance}&phone={$data['phone']}&message={$message}&media_url={$data['media_url']}";
        return $this->action($url);
    }
    
    private function action($url)
    {
        if (config('whatsapp.default_provider') == 'king_digital' && config('whatsapp.send_msg') == 1) {

            $response = Http::get($url);
            if ($response == "Authentication failed. Invalid credentials.") {
                return array(
                    'status' => 401,
                    'msg' => $response,
                );
            }
            return array(
                'status' => $response->json()['status'],
                'msg' => $response->json()['msg'],
            );
        }
    }
}
