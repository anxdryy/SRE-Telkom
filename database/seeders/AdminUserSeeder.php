<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@sretelu.test')],
            [
                'name' => env('ADMIN_NAME', 'SRE Admin'),
                'password' => env('ADMIN_PASSWORD', 'change-me-now'),
            ]
        );
    }
}
