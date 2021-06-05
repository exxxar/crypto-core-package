<?php

namespace Cryptolib\CryptoCore\Models\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "senderUserId"=> $this->sender_user_id,
            "recipientUserId"=> $this->recipient_user_id,
            "data"=> $this->data,
            "status"=> $this->status,
        ];
    }
}
