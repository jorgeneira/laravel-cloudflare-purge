<?php

namespace MicheleCurletta\LaravelCloudflarePurge;

use Illuminate\Support\ServiceProvider;

class CloudflarePurgeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->publishes([
            __DIR__.'/../config/laravel-cloudflare-purge.php' => config_path('laravel-cloudflare-purge.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-cloudflare-purge.php', 'laravel-cloudflare-purge');

        $this->app->bind('command.cloudflare-cache:purge', CloudflarePurgeCommand::class);

        $this->commands([
            'command.cloudflare-cache:purge',
        ]);
    }
}
