<?php

namespace Cryptolib\CryptoCore\listeners;

use Cryptolib\CryptoCore\Classes\UserPayloadServiceForServer;
use Cryptolib\CryptoCore\events\HandleMSEvent;
use Cryptolib\CryptoCore\events\HandlerResultFormEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class HandleMSListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return HandleMSEvent|object
     */
    public function handle(HandleMSEvent $event)
    {

        if (is_null($event))
            return $event;

        $userPayloadService = new UserPayloadServiceForServer();


        $hrf = $userPayloadService->handler($event->transferForm, $event->deviceId);

        event(new HandlerResultFormEvent($hrf));

        return $event;
    }
}
