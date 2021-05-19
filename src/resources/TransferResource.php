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
            "sender_user_id"=> $this->sender_user_id,
            "recipient_user_id"=> $this->recipient_user_id,
            "data"=> $this->data,
            "status"=> $this->status,
        ];
    }
}
