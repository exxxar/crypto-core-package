<?php

namespace Cryptolib\CryptoCore\Models\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransferCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
