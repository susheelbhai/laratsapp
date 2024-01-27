<?php

namespace Susheelbhai\WhatsApp\Repository;
use Illuminate\Support\Facades\Http;
use Susheelbhai\WhatsApp\Contracts\WhatsAppContract;

class SMS4power implements WhatsAppContract
{
    public $token;
    public $instance;
    public $end_point;
    public function __construct()
    {
        $this->token = config('whatsapp.sms4power.api_key');
        $this->end_point = config('whatsapp.sms4power.end_point');
    }
    public function sendText($data)
    {
        $url = "{$this->end_point}?apikey={$this->token}&mobile={$data['phone']}&msg={$data['message']}";
        return $this->action($url);
    }
    public function sendOTP($data)
    {
          $message = "OTP to validate mobile no. for " . config('app.name') . " is " . $data['message'] . "  OTPs are SECRET. DO NOT disclose it to anyone. We NEVER asks for OTP on phone.";
        $url = "{$this->end_point}?apikey={$this->token}&mobile={$data['phone']}&msg={$message}";
        return $this->action($url);
    }
    public function sendPdf($data)
    {
        $message = $data['message'];
        $url = "{$this->end_point}?&apikey={$this->token}&mobile={$data['phone']}&msg={$message}&pdf={$data['pdf']}";
        return $this->action($url);
    }
    public function sendMedia($data)
    {
        $message = $data['message'];
        $url = "{$this->end_point}?&apikey={$this->token}&mobile={$data['phone']}&msg={$message}&pdf={$data['media_url']}";
        return $this->action($url);
    }
    
    private function action($url)
    {
        if (config('whatsapp.default_provider') == 'sms4power' && config('whatsapp.send_msg') == 1) {

          return  $response = Http::get($url);
            if ($response == "Authentication failed. Invalid credentials.") {
                return array(
                    'status' => 401,
                    'msg' => $response,
                );
            }
            return array(
                'status' => $response->json()['status'],
                'msg' => $response->json()['error'],
            );
        }
    }
}
