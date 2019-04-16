# Laravel SMS Misr

Ce plugin vous permet d'envoyer des SMS et des notifications SMS via [SmsMisr](https://www.smsmisr.com/) depuis votre application Laravel. 
Attention, SmsMisr autorise uniquement les SMS transactionnels.

## Sommaire

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Notifications](#notifications)
- [Support](#support)
- [Auteur](#auteur)
- [Licence](#licence)

## Requirements

- PHP >= 7
- Laravel 5.3 à Laravel 5.7
- Un compte SmsMisr avec un token SMS

## Installation

- Installation via composer :  
```bash
composer require ghanem/laravel-smsmisr
```

- (Facultatif) Ajoutez le ServiceProvider dans **config/app.php** :  
```php
Ghanem\LaravelSmsmisr\ServiceProvider::class,
```

- (Facultatif) Publiez le fichier de config **smsmisr** :  
```bash
php artisan vendor:publish --provider="Ghanem\LaravelSmsmisr\ServiceProvider"
```

- Configurez le plugin dans votre `.env` (ou le fichier de config)
```
SMSMISR_USERNAME="username_smsMisr"
SMSMISR_PASSWORD="password"
SMSMISR_FROM="APPNAME"
```

## Usage

Envoyer un SMS :
```php
// Globalement
app('smsmisr')->send("hello world", "+33610203040");

// DI
public function myMethod(\Ghanem\LaravelSmsmisr\Smsmisr $mailjet) {
    $mailjet->send("hello world", "+33610203040");  
}
```

## Notifications

Ce plugin est compatible avec les [notifications Laravel](https://laravel.com/docs/5.7/notifications).

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
    	    "C'est ça que vous appelez une fondue ?", 
    	    $notifiable->phonenumber
        );
    }
}
```

### API

**Ghanem\LaravelSmsmisr\SmsmisrMessage**

```
    // Constructeur
    (new SmsmisrMessage(string $message, string $to))
    
    // Spécifier le destinataire
        ->to(string $to)
        
    // Spécifier l'expéditeur
        ->from(string $from)
        
    // Nettoyer les caractères unicodes
        ->unicode(bool $unicode = true)
```

### Un mot sur l'unicode

Par défaut les caractères unicodes sont envoyés dans le SMS. La méthode `unicode(bool $unicode = true)`, permet d'activer ou non l'unicode.
Une fois désactivé, l'unicode sera nettoyé pour ne laisser place qu'aux [caractères GSM 03.38](https://www.etsi.org/deliver/etsi_gts/03/0338/05.00.00_60/gsmts_0338v050000p.pdf).

## Support

N'hésitez pas à utiliser le gestion d'issus pour vos retours.


## Licence

MIT
