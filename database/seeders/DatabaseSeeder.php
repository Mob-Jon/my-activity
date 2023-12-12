<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'phone_number' => '09123456789',
                'type' => 'admin',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'user001',
                'email' => 'user001@gmail.com',
                'phone_number' => '09123456789',
                'type' => 'user',
                'password' => Hash::make('password001'),
            ],
            [
                'name' => 'user002',
                'email' => 'user002@gmail.com',
                'phone_number' => '09123456789',
                'type' => 'user',
                'password' => Hash::make('password002'),
            ]
        ]);
    }
}
