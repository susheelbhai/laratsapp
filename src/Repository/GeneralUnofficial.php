<?php

namespace Susheelbhai\WhatsApp\Repository;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Susheelbhai\WhatsApp\Contracts\WhatsAppContract;

class GeneralUnofficial implements WhatsAppContract
{
    public $token;
    public $instance;
    public $end_point;
    public function __construct()
    {
        $this->token = config('whatsapp.general_unofficial.token');
        $this->instance = config('whatsapp.general_unofficial.instance');
        $this->end_point = config('whatsapp.general_unofficial.end_point');
    }
    public function sendText($data)
    {
        $url = "{$this->end_point}?type=text&access_token={$this->token}&instance_id={$this->instance}&number={$data['phone']}&message={$data['message']}";
        // dd($url);
        return $this->action($url);
    }
    public function sendOTP($data)
    {
        $message = "OTP to validate mobile no. for " . config('app.name') . " is " . $data['message'] . "  OTPs are SECRET. DO NOT disclose it to anyone. We NEVER asks for OTP on phone.";
        $url = "{$this->end_point}?type=text&access_token={$this->token}&instance_id={$this->instance}&number={$data['phone']}&message={$message}";
        return $this->action($url);
    }
    public function sendPdf($data)
    {
        $message = $data['message'];
        $url = "{$this->end_point}?&apikey={$this->token}&number={$data['phone']}&msg={$message}&pdf={$data['pdf']}";
        return $this->action($url);
    }
    public function sendMedia($data)
    {
        $message = $data['message'];
        $url = "{$this->end_point}?type=media&access_token={$this->token}&instance_id={$this->instance}&number={$data['phone']}&message={$message}&media_url={$data['media_url']}";
        return $this->action($url);
    }
    
    private function action($url)
    {
        if (config('whatsapp.default_provider') == 'general_unofficial' && config('whatsapp.send_msg') == 1) {
            $client = new Client();
            $response = $client->get($url);
        
            $response = json_decode($response->getBody(), true) ;
            if ($response == "Authentication failed. Invalid credentials.") {
                return array(
                    'status' => 401,
                    'msg' => $response,
                );
            }
            return array(
                'status' => $response['status'],
                'msg' => $response['message'],
            );
        }
    }
}
