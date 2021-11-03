# Laravel SMS Misr (EGYPT)

[![Latest Stable Version](https://poser.pugx.org/ghanem/laravel-smsmisr/v/stable)](https://packagist.org/packages/ghanem/laravel-smsmisr) [![Total Downloads](https://poser.pugx.org/ghanem/laravel-smsmisr/downloads)](https://packagist.org/packages/ghanem/laravel-smsmisr) [![Latest Unstable Version](https://poser.pugx.org/ghanem/laravel-smsmisr/v/unstable)](https://packagist.org/packages/ghanem/laravel-smsmisr) [![License](https://poser.pugx.org/ghanem/laravel-smsmisr/license)](https://packagist.org/packages/ghanem/laravel-smsmisr)

Laravel Package that's allows you to send SMS and SMS notifications via [SmsMisr](https://www.smsmisr.com/) from your Laravel application.

## Summary

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Notifications](#notifications)
- [Licence](#licence)

## Requirements

- PHP >= 7
- Laravel 5.3+
- account in Sms Misr (username and password)

## Installation

- Installation via composer :  
```bash
composer require ghanem/laravel-smsmisr
```
### Laravel 5.5+

If you're using Laravel 5.5 or above, the package will automatically register the `Smsmisr` provider and facade.

### Laravel 5.4 and below

Add `Ghanem\LaravelSmsmisr\SmsmisrServiceProvider` to the `providers` array in your `config/app.php`:

```php
'providers' => [
    // Other service providers...

    Ghanem\LaravelSmsmisr\SmsmisrServiceProvider::class,
],
```

Or add an alias in your `config/app.php`:

```php
'aliases' => [
    ...
    'Smsmisr' => Ghanem\LaravelSmsmisr\Smsmisr::class,
],
```


- Publish the config & views by running **smsmisr** :  
```bash
php artisan vendor:publish --provider="Ghanem\LaravelSmsmisr\SmsmisrServiceProvider"
```

- Then update `config/smsmisr.php` with your credentials. Alternatively, you can update your `.env` file with the following:

```dotenv
SMSMISR_USERNAME=my_username
SMSMISR_PASSWORD=my_password
SMSMISR_SENDER=my_sender
```

## Usage

If you want to use the facade interface, you can `use` the facade class when needed:

```php
use use Ghanem\LaravelSmsmisr\Facades\Smsmisr;
    ...
    public function myMethod() {
        Smsmisr::send("hello world", "201010101010");  
    }
```
if you need use golbal:
```php
// Global
app('smsmisr')->send("hello world", "201010101010");
```

## Notifications

You can use the channel in your via() method inside the notification:


```php
namespace App\Notifications;

use Ghanem\LaravelSmsmisr\SmsmisrChannel;
use Ghanem\LaravelSmsmisr\SmsmisrMessage;
use Illuminate\Notifications\Notification;

class ExampleNotification extends Notification
{
    public function via($notifiable)
    {
        return [SmsmisrChannel::class];
    }
    
    public function toSmsmisr($notifiable)
    {
    	return new SmsmisrMessage(
            'Your message here',
    	    $notifiable->phone
        );
    }
}
```

### API

**Ghanem\LaravelSmsmisr\SmsmisrMessage**

```
    (new SmsmisrMessage(string $message, string $to))
        ->to(string $to)
        ->from(string $from)
        ->unicode(bool $unicode = true)
```


## Licence

MIT
