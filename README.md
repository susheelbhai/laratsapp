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

### License

This Multi Auth Package is developed by susheelbhai for personal use software licensed under the [MIT license](http://opensource.org/licenses/MIT)