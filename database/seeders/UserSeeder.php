<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => 'Kasir',
            'username' => 'arief',
            'password' => Hash::make('arief0'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
