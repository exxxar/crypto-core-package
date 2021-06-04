<?php

namespace Cryptolib\CryptoCore\events;

use Cryptolib\CryptoCore\Forms\TransferForm;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HandleMSEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transferForm;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TransferForm $transferForm)
    {
        $this->transferForm = $transferForm;
    }


}
