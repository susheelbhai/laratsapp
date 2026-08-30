<?php

namespace Susheelbhai\WhatsApp\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * File-based store for the mock WhatsApp inbox (viewable in the unified
 * /mock_message inbox under the WhatsApp tab). Messages are stored as individual
 * JSON files under storage/app/whatsapp_mock so they survive `cache:clear` and
 * match the mail inbox feature set (read/unread, view, individual delete).
 */
class MockInbox
{
    private const MAX_MESSAGES = 100;

    public static function directory(): string
    {
        return storage_path('app/whatsapp_mock');
    }

    /**
     * @param  array{phone?: string, message?: string, type?: string}  $data
     */
    public static function store(array $data): void
    {
        $dir = self::directory();
        File::ensureDirectoryExists($dir);

        $message = (string) ($data['message'] ?? '');
        $id = now()->format('YmdHisv').'-'.Str::random(6);

        $entry = [
            'id' => $id,
            'phone' => (string) ($data['phone'] ?? ''),
            'message' => $message,
            // No explicit OTP for WhatsApp; the inbox UI detects codes from the
            // body with a keyword-aware matcher (avoids misreading phone numbers).
            'otp' => null,
            'type' => (string) ($data['type'] ?? 'text'),
            'read' => false,
            'snippet' => Str::limit(trim($message), 140),
            'size' => strlen($message),
            'sent_at' => now()->toDateTimeString(),
        ];

        File::put($dir.'/'.$id.'.json', json_encode($entry, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        self::prune();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function all(): array
    {
        $messages = [];

        foreach (self::files() as $file) {
            $data = self::decode($file);

            if ($data !== null) {
                $data['read'] = (bool) ($data['read'] ?? false);
                $messages[] = $data;
            }
        }

        return $messages;
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function find(string $id): ?array
    {
        $path = self::directory().'/'.basename($id).'.json';

        return File::exists($path) ? self::decode($path) : null;
    }

    public static function clear(): void
    {
        $dir = self::directory();

        if (File::isDirectory($dir)) {
            File::cleanDirectory($dir);
        }
    }

    public static function delete(string $id): void
    {
        $path = self::directory().'/'.basename($id).'.json';

        if (File::exists($path)) {
            File::delete($path);
        }
    }

    public static function markRead(string $id): void
    {
        $data = self::find($id);

        if ($data === null || ($data['read'] ?? false) === true) {
            return;
        }

        $data['read'] = true;
        File::put(self::directory().'/'.basename($id).'.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public static function markAllRead(): void
    {
        foreach (self::files() as $file) {
            $data = self::decode($file);

            if ($data !== null && ($data['read'] ?? false) !== true) {
                $data['read'] = true;
                File::put($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }

    public static function unreadCount(): int
    {
        $count = 0;

        foreach (self::files() as $file) {
            $data = self::decode($file);

            if ($data !== null && ($data['read'] ?? false) !== true) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * @return array<int, string>
     */
    private static function files(): array
    {
        $dir = self::directory();

        if (! File::isDirectory($dir)) {
            return [];
        }

        $files = glob($dir.'/*.json') ?: [];
        rsort($files);

        return $files;
    }

    /**
     * @return array<string, mixed>|null
     */
    private static function decode(string $path): ?array
    {
        $data = json_decode(File::get($path), true);

        return is_array($data) ? $data : null;
    }

    private static function prune(): void
    {
        foreach (array_slice(self::files(), self::MAX_MESSAGES) as $old) {
            File::delete($old);
        }
    }
}
