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

### License

This Multi Auth Package is developed by susheelbhai for personal use software licensed under the [MIT license](http://opensource.org/licenses/MIT)