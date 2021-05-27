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
            "userId"=> $this->user_id,
            "deviceId"=> $this->device_id,
            "active"=> $this->active,
        ];
    }
}
