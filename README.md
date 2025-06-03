# Yomo7 Whami

A Laravel package for keyword linking with Whami link and tracking in Yomo7 applications.

## Features

- Keyword linking with tracking in the format `{keyword}_{attributioncode}`
- Database storage for keyword tracking data
- API endpoints for processing and retrieving keyword data
- Event-based system for handling keyword actions
- Configurable keywords for different channels

## Installation

You can install the package via composer:

```bash
composer require yomo7/whami
```

After installing the package, publish the configuration and migrations:

```bash
php artisan vendor:publish --tag=whami-config
php artisan vendor:publish --tag=whami-migrations
php artisan migrate
```

## Configuration

After publishing the configuration, you can find the config file at `config/whami.php`. Here you can define your keywords for different channels:

```php
return [
    'keywords' => [
        'whatsapp' => [
            // Your WhatsApp-specific keyword handlers here
            \App\Whami\Handlers\PromotionKeywordHandler::class,
        ],
        'ussd' => [
            // Your USSD-specific keyword handlers here
        ],
        'messenger' => [
            // Your Messenger-specific keyword handlers here
        ],
        'global' => [
            // Keywords that are registered irrespective of channel or context
            \App\Whami\Handlers\GlobalKeywordHandler::class,
        ]
    ]
];
```

## Usage

### Booting the Whami Service

In your application's service provider or bootstrap process, boot the Whami service with the current channel:

```php
use Yomo7\Whami\WhamiKeywordSubscriber;

// Boot Whami for WhatsApp channel
WhamiKeywordSubscriber::boot('whatsapp');
```

### Processing Keywords

You can process keywords in your application using the helper function:

```php
// Process a keyword with attribution code
$result = whami_process('welcome_facebook', '+27123456789');

// Or parse a keyword without tracking
$parsed = whami_parse('welcome_facebook');
```

### Creating Keyword Handlers

Create a handler class that extends `Yomo7\Whami\Whami`:

```php
namespace App\Whami\Handlers;

use Yomo7\Whami\Whami;

class PromotionKeywordHandler extends Whami
{
    /**
     * Handle when a keyword is received
     */
    public function eventOnKeywordReceived(string $keyword, ?string $attributionCode, ?string $number)
    {
        // Show a specific bot view in WhatsApp
        // Trigger a specific flow
        // Log the interaction for analytics
    }
}
```

Then register your handler in the config file.

### API Endpoints

The package provides the following API endpoints:

- `POST /api/whami/process` - Process a keyword
- `GET /api/whami/number/{number}` - Get keywords by number
- `GET /api/whami/attribution/{attributionCode}` - Get keywords by attribution code

## License

Proprietary - All rights reserved.
