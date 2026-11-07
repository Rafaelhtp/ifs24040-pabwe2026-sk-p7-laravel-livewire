<?php

return [
    'endpoint' => rtrim(env('OPENAI_ENDPOINT', 'https://api.openai.com/v1'), '/'),
    'key' => env('OPENAI_KEY', ''),
    'model' => env('OPENAI_MODEL', 'nvidia/nemotron-3-ultra-550b-a55b:free'),
];

