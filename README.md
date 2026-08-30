# Send WhatsApp message to custom phone number

## Installation

### Laravel
Require this package in your composer.json and update composer. This will download the package.


    composer require susheelbhai/laratsapp

## Configuration


### Vendor Publish

Publish config files using the following command 

  ```
  php artisan vendor:publish --tag="whatsapp" --force 
  ```  


### Final Step


Add environment valriable by runnung the command
```
php artisan whatsapp:update_env
```
go to .env file and put value of the required variables

### Application Guide


Import facade at the top of the class after namespace
```
use WhatsApp;
```
Create $data variable and call the facade

Text message example

```
$data = [
            'phone' => '9999999999',
            'message' => 'message content'
        ];
WhatsApp::sendText($data);
```

Text otp example

```
$data = [
            'phone' => '9999999999',
            'message' => 'otp'
        ];
WhatsApp::sendOTP($data);
```

Media message example

```
$data = [
            'phone' => '9999999999',
            'message' => 'message content',
            'media_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf'
        ];
WhatsApp::sendMedia($data);
```
Make sure media url is available on live server and accessible publicly

## You can aslo use this package with laravel notification class 

### add channel name whatsapp in via method. following is the example
```
public function via(object $notifiable): array
    {
        $channels = [];
        if (config('mail.send_mail') == 1 && isset($notifiable->email)) {
            $channels[] = 'mail';
        }
        if (config('whatsapp.send_msg') == 1 && isset($notifiable->phone)) {
            $channels[] = 'whatsapp';
        }
        return $channels;
    }
```

### Now add the other method by which you want to send the message. you can use 1 or more from the following

```
 public function toWhatsAppText($notifiable)
    {
        return 'Thank you for contacting '.config('app.name').'. We have received your message and will get back to you shortly.';
    }
```

```
 public function toWhatsAppOTP($notifiable)
    {
        return '223344';
    }
```

```
 public function toWhatsAppPdf($notifiable)
    {
        return [
            'message' => 'Thank you for contacting '.config('app.name').'. We have received your message and will get back to you shortly.',
            'media_url' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
        ];
    }
```

```
 public function toWhatsAppMedia($notifiable)
    {
        return [
            'message' => 'Thank you for contacting '.config('app.name').'. We have received your message and will get back to you shortly.',
            'media_url' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
        ];
    }
```

## Mock Provider & Inbox (local testing)

Use the mock provider to test WhatsApp/OTP flows locally without a real
WhatsApp account or API keys — like Mailpit, but for WhatsApp.

Set the endpoint to `mock` in `.env` (and enable sending):

```env
SEND_WHATSAPP_MSG=1
WHATSAPP_END_POINT=mock
```

When `WHATSAPP_END_POINT=mock`, `default_provider` resolves to `mock`
automatically. Messages are **not** sent to a real gateway — each one is
captured into a file-based inbox (`storage/app/whatsapp_mock`) and shown in the
**WhatsApp tab** of the unified message inbox provided by `laravel-basekit`:

```
GET  /mock_message?channel=whatsapp   # (the old /whatsapp_mock URL redirects here)
```

There you can view each message (body, recipient, extracted OTP with copy
button, type, time), mark read/unread, delete individual messages, search, and
clear all — the same feature set as the email inbox.

Captured messages are also available programmatically:

```php
use Susheelbhai\WhatsApp\Support\MockInbox;

MockInbox::all();          // captured messages (newest first)
MockInbox::find($id);      // one message
MockInbox::delete($id);    // delete one
MockInbox::markRead($id);  // mark read
MockInbox::clear();        // empty the inbox
```

Notes:
- Capture happens **only** when the mock provider is active. The inbox UI (in
  basekit) is registered **only** when `APP_ENV` is not `production`, so real
  OTPs are never exposed.
- In non-production, the service redirects to `WHATSAPP_TEST_NUMBER`.
- Switch back to a real provider by setting `WHATSAPP_END_POINT` to a real API
  endpoint — no code changes required.

### License

This Multi Auth Package is developed by susheelbhai for personal use software licensed under the [MIT license](http://opensource.org/licenses/MIT)