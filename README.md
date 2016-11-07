# Clear Cloudflare cache with ease

This Laravel 5 package allows you to clear Cloudflare cache through a simple Artisan command.

## Getting Started

These instructions allows you to install the package into an existing Laravel app.

### Prerequisities

Laravel 5 up&running installation.


### Installation

You can install this package via Composer using:

```bash
composer require michelecurletta/laravel-cloudflare-purge
```

You must also install this service provider.

```php
// config/app.php
'providers' => [
    ...
    MicheleCurletta\LaravelCloudflarePurge\LaravelCloudflarePurgeServiceProvider::class,
    ...
];
```

You must make sure that you've setted the right application url into config/app.php

```php
// config/app.php
 'url' => env('CLOUDFLARE_ZONE_ID', 'this-is-the-zone-id'),
```
### Usage

Once you have installed the package, you can run the following command:

```bash
php artisan cloudfare-cache:clear
```
All done! Your Cloudflare cache is cleaned!

### Suggestion

Run this command during deployment process in order to automate the cleaning process before you app's new version becomes active!
