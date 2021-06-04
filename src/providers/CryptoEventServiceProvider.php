<?php

namespace Cryptolib\CryptoCore\providers;

use Cryptolib\CryptoCore\Events\HandleMSEvent;
use Cryptolib\CryptoCore\Listeners\HandleMSListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class CryptoEventServiceProvider extends ServiceProvider
{

    protected $listen = [
        HandleMSEvent::class => [
            HandleMSListener::class,
        ]
    ];


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
