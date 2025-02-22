<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Deni Muhamad Ikbal',
            'email' => 'admin@rekapin.com',
            'password' => Hash::make('password'),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => 1, // Ganti dengan ID role yang sesuai
            'model_type' => 'App\Models\User', // Ganti jika namespace model berbeda
            'model_id' => 1,
        ]);
    }
}
