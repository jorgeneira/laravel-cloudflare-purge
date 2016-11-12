<?php

return [

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

];