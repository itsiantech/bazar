<?php

return [
    'bkash' => [
        'username' => env('BKASH_USERNAME', 'sandboxTokenizedUser01'),
        'password' => env('BKASH_PASSWORD', 'sandboxTokenizedUser12345'),
        'key' => env('BKASH_APP_KEY', '7epj60ddf7id0chhcm3vkejtab'),
        'secret' => env('BKASH_APP_SECRET', '18mvi27h9l38dtdv110rq5g603blk0fhh5hg46gfb27cp2rbs66f'),
        'base_url' => env('BKASH_BASE_URL', 'https://checkout.sandbox.bka.sh/v1.2.0-beta'),
        'token_life' => env('BKASH_TOKEN_LIFE', 3600)
    ]
];
