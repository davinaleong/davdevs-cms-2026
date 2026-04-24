<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::query()->updateOrCreate(
            ['email' => env('ADMIN_DEFAULT_EMAIL', 'admin@example.com')],
            [
                'name' => env('ADMIN_DEFAULT_NAME', 'Default Admin'),
                'password' => env('ADMIN_DEFAULT_PASSWORD', 'changeme123'),
                'must_change_password' => true,
                'email_verified_at' => now(),
            ],
        );
    }
}
