<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(7)->create();
        User::create([
            'name' => 'ADMIN ACCOUNT',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'email_verified_at' => now(),
            'password' => '$2a$12$ygXih5Jr3x9TNEOnqfJJb.Hy.1dF2mA7D.PjgVsB8ueKE6HViodP6', // 1
            'role' => 'admin'
        ]);
    }
}
