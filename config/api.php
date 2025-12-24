<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    |
    | This is the base URL for the API endpoints. The port is determined
    | by how you start the server:
    |
    | Default: php artisan serve (port 8000)
    | Custom:  php artisan serve --port=8001
    |
    | Update APP_URL in your .env file to match your server configuration.
    |
    */

    'base_url' => env('APP_URL', 'http://localhost:8000') . '/api',

    /*
    |--------------------------------------------------------------------------
    | API Prefix
    |--------------------------------------------------------------------------
    |
    | The prefix for all API routes. This is configured in bootstrap/app.php
    | and routes/api.php
    |
    */

    'prefix' => 'api',
];

