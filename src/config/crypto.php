<?php

return [
    "url"=>env("APP_CRYPTOGRAPHIC_URL","http://hf.trusted-solutions.ru:8080/cryptoservice"),
    'prefix' => 'crypto',
    'middleware' => ['web'],
    'server_user_id' => env("SERVER_USER_ID"),
    'dispatch_delay' => env("DISPATCH_DELAY",1),
    'app_prefix' => env("APP_PREFIX",''),
];
