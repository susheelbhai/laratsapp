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
            'message' => 'message content'
            'media_url' => 'http://url.extension/media_file'
        ];
WhatsApp::sendMedia($data);
```
Make sure media url is available on live server and accessible publicly

### License

This Multi Auth Package is developed by susheelbhai for personal use software licensed under the [MIT license](http://opensource.org/licenses/MIT)