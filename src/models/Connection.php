<?php

namespace Cryptolib\CryptoCore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "device_id",
        "active"
    ];
}
