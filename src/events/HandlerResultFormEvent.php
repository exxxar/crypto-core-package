<?php

namespace Cryptolib\CryptoCore\Events;

use Cryptolib\CryptoCore\forms\HandlerResultForm;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HandlerResultFormEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $hrf;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(HandlerResultForm $handlerResultForm)
    {
        $this->hrf = $handlerResultForm;
    }


}
