# Purge Cloudflare cache with ease

This Laravel 5 package allows you to easly clear Cloudflare cache through a simple Artisan command.

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

You must make sure that you've setted the right Cloudflare's parameters url into config/laravel-cloudflare-purge.php

```php
 /*
    |--------------------------------------------------------------------------
    | Cloudflare email
    |--------------------------------------------------------------------------
    |   The email used with Cloudflare account
    |   
    */

    'email' => env('CLOUDFLARE_EMAIL', ''),

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |   The API Key used to perform requests to Cloudflare's API.
    |   You can find it into your account's settings page.
    |   
    |
    */

    'api_key' => env('CLOUDFLARE_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Domain name
    |--------------------------------------------------------------------------
    |   The domain whose the cache is related to.
    |   
    |
    */

    'zone_name' => env('CLOUDFLARE_DOMAIN_NAME', ''),
```
### Usage

Once you have installed the package, you can run the following command:

```bash
php artisan cloudflare-cache:purge
```
All done! Your Cloudflare cache is purged!
NOTE: the cache invalidation process can take up to 30 seconds to complete the propagation.

### Suggestion

Run this command during deployment process in order to automate the cache invalidation process before you app's new version becomes active!
