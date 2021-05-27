<?php

return [
    "url"=>env("APP_CRYPTOGRAPHIC_URL","http://81.200.255.35:8080/crypto-service"),
    'prefix' => 'crypto',
    'middleware' => ['web'],
];
