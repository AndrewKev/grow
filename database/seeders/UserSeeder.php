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
                'nama' => 'admin1',
                'username' => 'admin1',
                'password' => Hash::make('adm001'),
                'level' => 1, // admin
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        DB::table('users')->insert(
            [
                'nama' => 'admin2',
                'username' => 'admin2',
                'password' => Hash::make('adm002'),
                'level' => 2, // admin
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        DB::table('users')->insert(
            [
                'nama' => 'admin3',
                'username' => 'admin3',
                'password' => Hash::make('adm003'),
                'level' => 3, // admin
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'Alan',
                'username' => 'Alan',
                'password' => Hash::make('sls001'),
                'level' => 0, // sales
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'Alan2',
                'username' => 'Alan2',
                'password' => Hash::make('sls001'),
                'level' => 0, // sales
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'Fajar',
                'username' => 'Fajar',
                'password' => Hash::make('sls002'),
                'level' => 0, // sales
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'Zanu',
                'username' => 'Zanu',
                'password' => Hash::make('sls003'),
                'level' => 0, // sales
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
