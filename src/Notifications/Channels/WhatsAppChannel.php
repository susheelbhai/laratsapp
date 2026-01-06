<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Susheelbhai\WhatsApp\Services\WhatsAppService;

/**
 * WhatsAppChannel handles sending notifications via WhatsApp.
 */
class WhatsAppChannel
{
    protected $whatsAppService;

    public function __construct()
    {
        $this->whatsAppService = app(WhatsAppService::class);
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (!isset($notifiable->phone)) {
            return;
        }

        $phone = '91' . $notifiable->phone;

        try {
            $methods = [
                'toWhatsAppOTP' => 'sendOTP',
                'toWhatsAppText' => 'sendText',
                'toWhatsAppPdf' => 'sendPdf',
                'toWhatsAppMedia' => 'sendMedia',
            ];

            foreach ($methods as $method => $serviceMethod) {
                if (method_exists($notification, $method) && is_callable([$notification, $method])) {
                    $data = $notification->{$method}($notifiable);
                    if ($data) {
                        $payload = is_array($data) ? array_merge(['phone' => $phone], $data) : ['phone' => $phone, 'message' => $data];
                        $this->whatsAppService->{$serviceMethod}($payload);
                        return;
                    }
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
