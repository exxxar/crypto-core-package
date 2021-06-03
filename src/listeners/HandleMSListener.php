<?php

namespace Cryptolib\CryptoCore\Listeners;

use Cryptolib\CryptoCore\Classes\UserPayloadServiceForServer;
use Cryptolib\CryptoCore\Events\HandleMSEvent;
use Cryptolib\CryptoCore\Events\HandlerResultFormEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleMSListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(HandleMSEvent $event)
    {
        if (is_null($event))
            return;

        $userPayloadService = new UserPayloadServiceForServer();

        $hrf = $userPayloadService->handler($event->transferForm);

        event(new HandlerResultFormEvent($hrf));
    }
}
