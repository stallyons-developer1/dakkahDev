<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\User::create([
            'username' => 'admin',
            'name' => 'admin',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'gender' => 'admin',
            'role_id' => 1,
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'active' => 1,
            'is_super_admin' => 1,
        ]);
    }
}
