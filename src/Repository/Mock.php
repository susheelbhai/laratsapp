<?php

namespace Susheelbhai\WhatsApp\Repository;

use Susheelbhai\WhatsApp\Contracts\WhatsAppContract;
use Susheelbhai\WhatsApp\Support\MockInbox;

/**
 * Mock WhatsApp provider (WHATSAPP_END_POINT="mock").
 *
 * Instead of calling a real WhatsApp API, every message is captured into a
 * cache-backed inbox (see MockInbox) that can be viewed in the browser at
 * /whatsapp_mock — the WhatsApp equivalent of Mailpit for local development.
 */
class Mock implements WhatsAppContract
{
    public function sendText($data)
    {
        return $this->capture($data, 'text', (string) ($data['message'] ?? ''));
    }

    public function sendOTP($data)
    {
        // For OTP notifications, $data['message'] is the raw code.
        return $this->capture($data, 'otp', (string) ($data['message'] ?? ''));
    }

    public function sendPdf($data)
    {
        return $this->capture($data, 'pdf', (string) ($data['message'] ?? ''));
    }

    public function sendMedia($data)
    {
        return $this->capture($data, 'media', (string) ($data['message'] ?? ''));
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array{status: int, msg: string}
     */
    private function capture(array $data, string $type, string $message): array
    {
        // WhatsAppService appends " sent to <phone>" in non-production; strip it
        // so the stored message shows the clean body / OTP.
        $cleanMessage = preg_replace('/ sent to \d+\s*$/', '', $message) ?? $message;

        MockInbox::store([
            'phone' => $this->resolveRecipient($data),
            'message' => $cleanMessage,
            'type' => $type,
        ]);

        return [
            'status' => 200,
            'msg' => 'captured by mock whatsapp inbox',
        ];
    }

    /**
     * In non-production, WhatsAppService rewrites the phone to the test number
     * and appends " sent to <realPhone>" to the message. Recover the real
     * recipient so the inbox is accurate; otherwise fall back to the phone field.
     *
     * @param  array<string, mixed>  $data
     */
    private function resolveRecipient(array $data): string
    {
        $message = (string) ($data['message'] ?? '');

        if (preg_match('/ sent to (\d+)\s*$/', $message, $matches)) {
            return $matches[1];
        }

        return (string) ($data['phone'] ?? '');
    }
}
