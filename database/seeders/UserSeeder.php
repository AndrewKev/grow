<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        DB::table('users')->insert(
            [
                'nama' => 'admin',
                'username' => 'admin',
                'password' => Hash::make('adm001'),
                'level' => 1, // admin
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'sales',
                'username' => 'sales',
                'password' => Hash::make('sls001'),
                'level' => 2, // sales
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
