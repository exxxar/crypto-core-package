<?php

namespace Cryptolib\CryptoCore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        "sender_user_id",
        "recipient_user_id",
        "data",
        "status"
    ];

    protected $casts = [
      "status"=>"object"
    ];
}
