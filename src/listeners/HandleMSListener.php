<?php

namespace Cryptolib\CryptoCore\listeners;

use Cryptolib\CryptoCore\Classes\UserPayloadServiceForServer;
use Cryptolib\CryptoCore\Events\HandleMSEvent;
use Cryptolib\CryptoCore\Events\HandlerResultFormEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class HandleMSListener implements ShouldQueue
{

    public $connection = "database";

    public $queue = "listeners";

    public $delay = 60;

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
     * @return HandleMSEvent|object
     */
    public function handle(HandleMSEvent $event)
    {
        Log::info("test");
        if (is_null($event))
            return $event;

        $userPayloadService = new UserPayloadServiceForServer();
        Log::info("test2");
        $hrf = $userPayloadService->handler($event->transferForm);
        Log::info("test3");
        event(new HandlerResultFormEvent($hrf));
        Log::info("test4");

        return $event;
    }
}
