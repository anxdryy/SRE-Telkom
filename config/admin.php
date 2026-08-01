<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Seeded Admin Account
    |--------------------------------------------------------------------------
    |
    | These values are used by the AdminUserSeeder to create/update the
    | single admin account for the admin panel. They must be set in your
    | .env file — see the README for details.
    |
    */

    'name' => env('ADMIN_NAME', 'SRE Admin'),
    'email' => env('ADMIN_EMAIL'),
    'password' => env('ADMIN_PASSWORD'),

];
