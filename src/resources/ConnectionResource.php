<?php

namespace Cryptolib\CryptoCore\Models\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConnectionResource extends JsonResource
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
            "user_id"=> $this->user_id,
            "device_id"=> $this->device_id,
            "active"=> $this->active,
        ];
    }
}
